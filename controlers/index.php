<?php

	require("bootstrap.php");

	$app->action("/", function (&$view))
	{
		$view = "index";
		$items = array(
			array("route" => "login", "name" => "The login page"),
			array("route" => "cities", "name" => "The city api"),
		);

		return compact($items);
	}
?>
