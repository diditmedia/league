<?php

class User extends Object
{
	protected $table = 'Users';
	protected $table_id_col = 'id';

	public function __construct($id = false)
	{
		parent::__construct();

		if($id) {
			$this->getByID($id);
		}
	}

}