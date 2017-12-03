<?php

function getAuthUser() {
	session_start();

	$db_host =  getenv('DB_HOST');
	$db_username = getenv('DB_USER');
	$db_password = getenv('DB_PASSWORD');
	$db_name = getenv('DB_NAME');

	if(isset($_SESSION['user_id'])) {
		$id = $_SESSION['user_id'];
		$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
		$query = "SELECT * FROM users WHERE `id` = '{$id}'";
		$query_result = $mysqli->query($query);
		return $query_result->fetch_assoc();	
	}
	return null;
}