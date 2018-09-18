<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$username = $db->quote($_POST['username']);
		$email = $db->quote($_POST['email']);
		$password = $db->quote(sha1($_POST['password']));

		$select = $db->query("SELECT * FROM users WHERE username=$username OR email=$email");
		if ($select->rowCount() == 0) {
			$select = $db->prepare("INSERT INTO users(username, password, email) VALUES(:username, :password, :email)");
            $select->execute(array('username' => $username, 'password' => $password, 'email' => $email));
			mail($_POST['email'] , "new count" , "Welcome ".$_POST['username'].", you successfully register to Camagru. let's go !!" );
			header('Location:'.WEBROOT.'login.php');
		} else {
		    setFlash('someone already use this username or email', 'error');
		}
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
			    <label>Email</label>
				<?php echo input('email', 'email'); ?>
			</div>
			<div class="form-item">
			    <label>Password</label>
				<input type="password" id="password" name="password">
			</div>
			<div class="form-item is-buttons">
				<button class="button" type="submit">Create</button>
			</div>
		</form>
	</div>
<?php include 'partials/footer.php'; 

