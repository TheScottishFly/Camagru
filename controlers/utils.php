<?php

function dbConnect() {
    try{
        $db = new PDO('sqlite:'.dirname(__FILE__).'/../db.sqlite');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e) {
        echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
        die();
    }

    return $db;
}