<?php
$auth = 0;
include 'lib/includes.php';
include 'partials/header.php';

// $select = $db->query("SELECT works.name, works.id, works.slug, images.name as image_name FROM works LEFT JOIN images ON images.id = works.image_id");
// $works = $select->fetchAll();

?>

	<h1  class="title"><a href="/">CAMAGRU</a></h1>

	<ul class="menu">
		<li><a href="<?php echo WEBROOT.'login.php'; ?>">signin</a></li>
		<li><a href="<?php echo WEBROOT.'newuser.php'; ?>">creat my camagru</a></li>
		<li><a href="<?php echo WEBROOT.'forget.php'; ?>">forget my password</a></li>
	</ul>

<?php include 'partials/footer.php'; ?>