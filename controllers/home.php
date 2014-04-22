<?php

class Home
{
	public function index()
	{
		$view = new View();

		$view->add('header');
		$view->add('home/index');
		$view->add('footer');

		$view->render();
	}

	public function about($param, $more)
	{
		echo __METHOD__ . ' '.$param;

		print_r($more);


	}

	public function user($param)
	{
		Loader::model('user');

		$user = new User($param);

		$view = new View();

		$view->add('header');
		$view->add('home/user', array('user' => $user));
		$view->add('footer');

		$view->render();
		
	}
}