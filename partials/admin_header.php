<!DOCTYPE html>
<html>
<head>
	<title>Camagru 42</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/kube/6.5.2/css/kube.min.css">
	<link rel="stylesheet" type="text/css" href="../static/style.css">
</head>
<body class="admin">
	<h1 class="title">Bienvenue, <?php echo $_SESSION['Auth']['username'] ?></h1>
	<div class="navigation">
		<ul>
			<li><a href="<?php echo WEBROOT ?>admin/">HOME</a></li>
			<li><a href="<?php echo WEBROOT ?>logout.php">Log out</a></li>
		</ul>
		<ul>
			<li><a href="all_creations.php"> View all creations</a></li>
			<li><a href="my_creations.php"> View my creations</a></li>
			<li><a href="new_creation.php"> Create new creation</a></li>
		</ul>
	</div>	
	<?php echo flash();