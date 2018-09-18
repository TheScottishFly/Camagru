<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['password'])){
	$username = $db->quote($_POST['username']);
	$password = sha1($_POST['password']);
	$sql = "SELECT * FROM users WHERE username=$username AND password=$password";
	$select = $db->query($sql);
	if ($select->rowCount() > 0){
		$_SESSION['Auth'] = $select->fetch();
		setFlash('Vous êtes connecté');
		header('Location:'.WEBROOT.'admin/index.php');  
		die();
	}
}
include 'partials/header.php';
?>
	<div>
		<h1><a href="/">CAMAGRU</a></h1>
		<form action="#" method="post">
			<div class="form-item">
			    <label>Username</label>
				<?php echo input('username'); ?>
			</div>
			<div class="form-item">
			    <label>Password</label>
				<input type="password" id="password" name="password">
			</div>
			<div class="form-item is-buttons">
				<button class="button" type="submit">Login</button>
			</div>
		</form>
	</div>
<?php include 'partials/footer.php'; 

