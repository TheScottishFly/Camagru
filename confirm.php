<?php

require_once("controlers/get_images.php");
require_once("controlers/utils.php");
require_once("plugins/includes.php");

if (isset($_GET['token'])) {
    $db = dbConnect();
    $select = $db->prepare("UPDATE users SET confirm=1 WHERE token = ? AND confirm = 0");
    $select->execute(array($_GET['token']));
    $_SESSION['user']['confirm'] = 1;
}
header("Location: new.php");