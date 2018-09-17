<?php 
include '../lib/includes.php';


if (isset($_GET['id'])) {
	$id = $db->quote($_GET['id']);
	$db->query("UPDATE images SET like_count = like_count + 1 WHERE id=$id");
	header('Location:'.WEBROOT.'admin/all_creations.php');
	die();
} else {
	header('Location:'.WEBROOT.'admin/');
	die();
}