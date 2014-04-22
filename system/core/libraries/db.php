<?php

class Db
{
	protected $conn;

	public function __construct($config = false)
	{
		if($config) {
			$dsn =  "{$config['driver']}:host={$config['hostname']};dbname={$config['dbname']}";
			$user = $config['user'];
			$passwd = $config['passwd'];
		} else {
			$dsn = DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME;
			$user = DB_USER;
			$passwd = DB_PASS;
		}

		$this->conn = new PDO($dsn, $user, $passwd);
	}

	public function query($sql, $data = false)
	{

		$stm = $this->conn->prepare($sql);

		if($data) {
			$stm->execute($data);
		} else {

			$stm->execute();
		}


		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res;


	}

	public function delete(&$obj)
	{
		if(is_object($obj)) {
			$table = $obj->getTable();
			$idCol = $obj->getTableIdCol();
			$id = $obj->{$idCol};

			$this->query("DELETE FROM {$table} WHERE {$idCol} = {$id}");

			unset($obj);
		}
	}

	public function insert($obj)
	{
		
		if(is_object($obj)) {
			$data = get_object_vars($obj);

			unset($data[$obj->getTableIdCol()]);

			$table = $obj->getTable();

			$insert = $this->createInsertString($data);

			$sql = "INSERT INTO {$table} ". $insert;

			if(array_key_exists('created_at', $data)) {
				$data['created_at'] = date('Y-m-d H:i:s');
			}

			$res = $this->query($sql, $data);

			return $this->conn->lastInsertId();
		}
	}

	public function update($obj)
	{

		
		if(is_object($obj)) {
			$data = get_object_vars($obj);

			$idCol = $obj->getTableIdCol();
			
			$table = $obj->getTable();


			$str = "UPDATE {$table} SET ";

			foreach($data as $col => $val) {

				if($col != $idCol) {

					$str .= "{$col} = :{$col}, ";
				}
			}

			$str = rtrim($str, ', ');

			$str .= " WHERE {$idCol} = :{$idCol}";

			if(array_key_exists('updated_at', $data)) {
				$data['updated_at'] = date('Y-m-d H:i:s');
			}

			$this->query($str, $data);
			
		} 
	}

	protected function createInsertString($data)
	{
		$str = '(';

		foreach($data as $col => $val) {
			$str .="{$col}, ";
		}

		$str = rtrim($str, ', ');

		$str .=') VALUES (';

		foreach($data as $col => $val) {
			$str .= ":{$col}, ";
		}

		$str = rtrim($str, ', ');

		$str .= ')';

		return $str;


	}

	protected function createUpdateString($data) 
	{

		

		$str = ' SET ';

		foreach($data as $col => $val) {

			
			$str .= "{$col} = :{$col}, ";
		}

		$str = rtrim($str, ', ');

		return $str;
	}


}


