<?php

class UserList
{
	public function get($limit = false, $offset = false)
	{
		$db = Loader::db();

		Loader::model('user');

		$sql = "SELECT * FROM Users";

		if($limit) {
			$sql .= " LIMIT {$limit}";
		}

		if($offset) {
			$sql .= ", {$offset}";
		}

		$users = $db->query($sql);

		foreach($users as $user) {
			$userObjects[] = new User($user['id']);
		}

		return $userObjects;
	}
}