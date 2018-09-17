<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['email'])) {

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

		// Email is Valid
		$email = $db->quote($_POST['email']);
		$select = $db->query("SELECT * FROM users WHERE email=$email");
		
		if ($select->rowCount() > 0) {

			// User found
			// Creat a recovery key to send it by email
			$salt = 'r9P+*p3CBT^qP^t@Y1|{~g9F[jOL)3_qlj>O)vPXymMyGiPQW(:aYkk^x?I63/.y';
			$password = hash('sha512', $salt.$_POST['email']);
			$reseturl = 'localhost:8080'.WEBROOT.'reset.php?q='.$password;

			$bodymail = "Hello,\nIf you really want to reset your password follow this link ".$reseturl."\nYour camagru Team";
			mail( $_POST['email'] , "Forget password" , $bodymail);
			setFlash('an email have been sent');
		
		} else {

			// No User Found
			setFlash('no email found', 'error');
		
		}
	}
}
include 'partials/header.php';
?>
	<div class="forget">
		<h1 class="title"><a href="/">CAMAGRU</a></h1>
		<form action="#"  method="post">
			<div class="formulaire email">
				<?php echo input('email', 'email'); ?>
			</div>
			<div class="formulaire submit">
				<input type="submit" value="Reset">
			</div>
		</form>		
	</div>

<?php include 'partials/footer.php'; 

