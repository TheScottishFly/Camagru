<?php
include_once "utils.php";
session_start();

function getAllImages($page) {
    $db = dbConnect();
    $low = $page * 5 - 5;
    $high  = $low + 5;
    $querystring = "SELECT * FROM images ORDER BY date DESC LIMIT %d,%d";
    $req = $db->query(sprintf($querystring, $low, $high));
    return $req;
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
