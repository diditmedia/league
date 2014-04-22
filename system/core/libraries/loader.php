<?php

class Loader
{
	public static function db()
	{
		//1st look for override folder
		if(file_exists(OVERRIDE_LIBRARY_DIR.SEP.'db.php')) {

			require_once(OVERRIDE_LIBRARY_DIR.SEP.'db.php');
		} else {

			require_once(SYS_CORE_LIBRARY_DIR.SEP.'db.php');
		}

		$db = new Db();

		return $db;
	}

	public static function model($model)
	{

		$file = MODEL_DIR.SEP.$model.EXT;

		if(file_exists($file)) {

			require_once($file);
		}
	}

	
}