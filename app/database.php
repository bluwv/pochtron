<?php

require_once '../config/database.settings.php';

try {
	$db = new PDO('mysql:host=localhost;charset=utf8mb4;dbname='.$dbname, $dbuser, $dbpass);
	$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
} catch(PDOException $err) {
	die($err->getMessage());
}
