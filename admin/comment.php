<?php 
include '../lib/includes.php';


// Récupérer l'image
if (isset($_GET['id'])) {
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT name, user_id FROM images WHERE id=$id");
	$image = $select->fetch();

	// Envoyer un commentaire par mail
	if (isset($_POST['content'])) {
		checkCsrf();
		$body = "Vous avez recu un nouveau commentaire de la part de ".$_SESSION['Auth']['username']." son message :\n".$_POST['content'];

		$user_id = $db->quote($image['user_id']);
		$select = $db->query("SELECT email FROM users WHERE id=$user_id");
		$mail = $select->fetch();

		mail( $mail['email'] , "Nouveau commentaire" , $body );
		setFlash('Commentaire bien envoyer');
		header('Location:'.WEBROOT.'admin/');
		die();
	}

} else {
	setFlash('Un probleme est survenu', 'error');
	header('Location:'.WEBROOT.'admin/');
	die();
}


include '../partials/admin_header.php';
?>

	<h1> Editer une work </h1>
	
	<div>
		<p><img src="<?php echo WEBROOT; ?>img/<?php echo $image['name']; ?>" width="500"></p>
	</div>

	<div>
		<form action="#" method="post">
			<div>
				<label for="content">Envoyer un Commentaire</label>
				<?php echo textarea('content'); ?>
			</div>
			<?php echo csrfInput(); ?>
			<button type="submit">Envoyer</button>
		</form>
	</div>

<?php include '../partials/footer.php'; ?>