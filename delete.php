<?php

require_once("controlers/utils.php");

authVerif(true);

if (isset($_GET['img'])) {
    $db = dbConnect();
    $select = $db->prepare("SELECT * FROM images WHERE id = ?");
    $select->execute(array($_GET['img']));
    $result = $select->fetchAll();
    if (count($result) > 0) {
        $img = $result[0];
        $select = $db->prepare("DELETE FROM images WHERE id = ?");
        $select->execute(array($_GET['img']));
        $path = getcwd();
        unlink($path."/resources/photos/".$img['name']);
    }
}

header('Location: index.php');