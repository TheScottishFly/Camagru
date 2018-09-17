<?php 
	require_once('database.php');

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

try {
	$sql = "CREATE TABLE IF NOT EXISTS `categories` (
			`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			`name` varchar(255) NOT NULL,
			`slug` varchar(255) NOT NULL
		);
		CREATE TABLE IF NOT EXISTS `images` (
			`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			`name` varchar(255) NOT NULL,
			`user_id` int(11) NOT NULL,
			`pub_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`like_count` int(11) NOT NULL
		);
		CREATE TABLE IF NOT EXISTS `users` (
			`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			`username` varchar(255) NOT NULL,
			`password` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL
		);
		CREATE TABLE IF NOT EXISTS `comments` (
			`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			`name` varchar(255) NOT NULL,
			`slug` varchar(255) NOT NULL,
			`content` longtext NOT NULL,
			`category_id` int(11) NOT NULL,
			`image_id` int(11) NOT NULL
		);
	";
	$db->exec($sql);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
