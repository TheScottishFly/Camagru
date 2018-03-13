<?php
include_once "utils.php";
session_start();

function getAllImages() {
    $db = dbConnect();
    return $db->query("SELECT * FROM images ORDER BY date DESC");
}

function getOneImage($img) {
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM images WHERE id = ?");
    return $req->execute(array($img));
}