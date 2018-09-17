<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

		// Email is Valid
		$username = $db->quote($_POST['username']);
		$email = $db->quote($_POST['email']);
		$password = $db->quote(sha1($_POST['password']));

		$select = $db->query("SELECT * FROM users WHERE username=$username OR email=$email");
		if ($select->rowCount() == 0) {

			// No user found create new one and send it an email
			$db->query("INSERT INTO users SET username=$username, password=$password, email=$email");
			mail( $_POST['email'] , "new count" , "Welcom to you ".$_POST['username'].", you successefully regiter to Camagru. lets start !!" );
			header('Location:'.WEBROOT.'login.php');

		} else {
			
			// User already Exist
			setFlash('someone already use this username or email', 'error');
		
		}
	}
}
include 'partials/header.php';
?>
	<div class="connection">
		<h1 class="title"><a href="/">CAMAGRU</a></h1>
		<form action="#" method="post">
			<div class="formulaire username">
				<?php echo input('username'); ?>
			</div>
			<div class="formulaire email">
				<?php echo input('email', 'email'); ?>
			</div>
			<div class="formulaire password">
				<input type="password" id="password" name="password">
			</div>
			<div class="formulaire submit">
				<input type="submit" value="Creer mon compte">
			</div>
		</form>
	</div>
<?php include 'partials/footer.php'; 

