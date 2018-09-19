<?php

require_once("controlers/get_images.php");
require_once("controlers/utils.php");
require_once("plugins/includes.php");

if (isset($_GET['token'])) {
    $db = dbConnect();
    $select = $db->prepare("UPDATE users SET confirm = TRUE WHERE token = ?");
    $select->execute(array($_GET['token']));
}
header('Location: /');