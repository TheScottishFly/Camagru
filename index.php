<?php
$auth = 0;
include 'lib/includes.php';
include 'partials/header.php';

// $select = $db->query("SELECT works.name, works.id, works.slug, images.name as image_name FROM works LEFT JOIN images ON images.id = works.image_id");
// $works = $select->fetchAll();

?>

	<h1><a href="/">CAMAGRU</a></h1>

	<div class="is-container-row">
		<div><a href="<?php echo WEBROOT.'login.php'; ?>">Login</a></div>
		<div><a href="<?php echo WEBROOT.'newuser.php'; ?>">Register</a></div>
		<div><a href="<?php echo WEBROOT.'forget.php'; ?>">Forgot</a></div>
	</ul>

<?php include 'partials/footer.php'; ?>
