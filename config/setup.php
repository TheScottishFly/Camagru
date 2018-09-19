<?php
require_once('database.php');

try{
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

try {
    $sql = ";
        CREATE TABLE `images` (
            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `title` varchar(255) NOT NULL,
            `name` varchar(255) NOT NULL,
            `author_id` int(11) NOT NULL,
            `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `nb_like` int(11) NOT NULL
        );
        CREATE TABLE `users` (
            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `username` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL
        );
        CREATE TABLE `comments` (
            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `author` varchar(255) NOT NULL,
            `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `text` longtext NOT NULL,
            `image_id` int(11) NOT NULL
        );
    ";
    $db->exec($sql);
}
catch(PDOException $e)
{
    echo $e->getMessage();
    die();
}
