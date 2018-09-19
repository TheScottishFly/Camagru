<?php
include_once "utils.php";
session_start();

function getAllImages() {
    $db = dbConnect();
    return $db->query("SELECT * FROM images ORDER BY date DESC");
}

function getImagesByAuth($id) {
  $db = dbConnect();
  $req = $db->prepare("SELECT * FROM images WHERE author_id = ? ORDER BY date DESC LIMIT 0,4");
  $req->execute(array($id));
  return $req;
}

function getOneImage($img) {
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM images WHERE id = ?");
    $req->execute(array($img));
    return $req->fetch();
}
