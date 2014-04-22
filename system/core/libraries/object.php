<?php

class Object
{

	protected $table;
	protected $table_id_col;
	protected $error = null;

	public function __construct()
	{
		$this->getObjectProps();
	}

	public function setTable($table)
	{
		$this->table = $table;
	}

	public function setTableIdCol($col)
	{
		$this->table_id_col = $col;
	}

	public function getTableIdCol()
	{
		return $this->table_id_col;
	}

	public function getTable()
	{
		return $this->table;
	}

	public function getByID($id)
	{
		$db = Loader::db();


		$res = $db->query("SELECT * FROM {$this->table} WHERE {$this->table_id_col} = {$id}");

		if(!empty($res)) {

			$this->setPropertiesFromArray($res[0]);
		} else {
			$error = new stdClass();
			$error->message = "User with ID: {$id} could not be found";
			$this->error = $error;
		}
	
	}

	protected function setPropertiesFromArray($arr)
	{
		if(is_array($arr)) {
			foreach($arr as $prop => $val) {
				$this->{$prop} = $val;
			}
		}
	}

	public function save()
	{
		$db = Loader::db();

		if(property_exists($this, $this->table_id_col) && $this->{$this->table_id_col} !='' && !is_null($this->{$this->table_id_col})) {
			$db->update($this);
		} else {
			$this->{$this->table_id_col} = $db->insert($this);
		}
		$this->getByID($this->{$this->table_id_col});
	}

	public function delete()
	{
		$db = Loader::db();

		$db->delete(&$this);

		$this->getObjectProps();
	}

	public function getError()
	{
		return $this->error;
	}

	/**
	 * Simply resets the object error to null 
	 * useful for occassions when you might check for errors
	 * and retry without halting the application.
	 * 
	 */
	public function clearError()
	{
		$this->error = null;
	}

	/**
	 *
	 *
	 * @param unknown $name
	 * @param unknown $a
	 * @return unknown
	 */
	public function __call($name, $a)
	{

		$prefix = substr($name, 0, 3);
		$prop = substr($name, 3, strlen($name) - 1);

		$prop = $this->convertFromCamelCase($prop);


		if ($prefix == 'get') {
			
			if(property_exists($this, $prop)) {

				return $this->{$prop};
			} else {
				return false;
			}

		} else if($prefix == 'set') {
			

			if(property_exists($this, $prop)) {

				$this->{$prop} = $a[0];
				
			} else {
				$this->setError("Property {$prop} is not valid");
			}

		}
	}

	protected function getObjectProps()
	{
		
		$db = Loader::db();

		$cols = $db->query("SHOW COLUMNS FROM {$this->table}");

		foreach($cols as $col) {

			foreach($col as $key => $val) {


				if($key == 'Field') {
					$this->{$val} = '';
				}
			}
		}
	}

	protected function convertFromCamelCase($name)
	{
		$camel = lcfirst($name);

		return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $camel));
	}

	protected function setError($message)
	{
		$error = new stdClass();
		$error->message = $message;
		$this->error = $error;
	}

} 