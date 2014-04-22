<?php

class Router
{
	protected $routes = array();

	public function add($path, $route)
	{
		$this->routes[$path] = $route;
	}

	public function routeRequest()
	{
		$path = trim($_SERVER['PATH_INFO'], '/');

		// var_dump($path);

		if($path == '') {
			$path = '/';
		}

		$route = $this->getRoute($path);

		if($route) {
			$routeData = $this->parseRoute($route);
		} else {
			$routeData = $this->parseRoute($path, '/');
		}
		
		$controllerPath = CONTROLLER_DIR.SEP.$routeData['controller'].EXT;
		$controller = ucfirst($routeData['controller']);
		$method = $routeData['method'];

		if(file_exists($controllerPath)) {

			require($controllerPath);
			$class = new $controller();

			if(array_key_exists('param', $routeData) && !array_key_exists('additionalParams', $routeData)) {

				$class->{$method}($routeData['param']);
			} else if(array_key_exists('additionalParams', $routeData)) {
				$class->{$method}($routeData['param'], $routeData['additionalParams']);
			} else {
				
				$class->{$method}();
			}

		} else {
			header("HTTP/1.0 404 Not Found");
		}
	}

	public function getRoute($path) 
	{

		if(array_key_exists($path, $this->routes)) {

			return $this->routes[$path];
		} else {
			return false;
		}
	}

	protected function parseRoute($route, $delim = "@")
	{
		$data = explode($delim, $route);
		$routeData['controller'] = $data[0];

		if(array_key_exists(1, $data)) {
			$routeData['method'] = $data[1];
		} else {
			$routeData['method'] = "index"; 
		}

		if(array_key_exists(2, $data)) {
			$routeData['param'] = $data[2];
		}

		if(count($data) > 3) {
			$routeData['additionalParams'] = array_slice($data, 3);
		}

		return $routeData;
	}
}