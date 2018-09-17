<?php 
include '../lib/includes.php';
include '../partials/admin_header.php';

// DELETE A IMAGE
$user = $_SESSION['Auth'];
if (isset($_GET['delete'])) {

	// jeton de securité
	checkCsrf();

	// recuperer l'image a supprimer
	$id = $db->quote($_GET['delete']);
	$select = $db->query("SELECT name, user_id FROM images WHERE id=$id");	
	$image = $select->fetch();

	if ($image['user_id'] == $user['id']) {
	
		// l'image est bien celle de l'utilisateur connecter
		// suppression du fichier
		unlink(IMAGES . '/' . $image['name']);

		// supression en bdd
		$db->query("DELETE FROM images WHERE id=$id");

		// message de confirmation
		setflash('L\'art doit rester ephemere. Votre creation a bien été suprimé');
		header('Location:'.WEBROOT.'admin/my_creations.php');
		die();
	}
}

// GET MY IMAGES
// $pp -> Pictures Per Pages
$ppp = 4;

// recuperer le nombre d'image enregistrées
$select = $db->query('SELECT COUNT(*) AS total FROM images');
$total_pic = $select->fetch();
$nb_pic = $total_pic['total'];

$nb_page = ceil($nb_pic / $ppp);

// Pagination du type all_creation.php?p=

if(isset($_GET['p'])) {

	// recuperer la valeur de la page courante passer en GET
	$cp = intval($_GET['p']);

	if($cp > $nb_page) {
		$cp=$nb_page;
	} else if ($cp < 1) {
		$cp = 1;
	}

} else {
	$cp = 1;
}

$first = ($cp-1) * $ppp;


$user_id = $db->quote($user['id']);
$select = $db->query("SELECT * FROM images WHERE user_id=$user_id ORDER BY pub_date DESC LIMIT $first, $ppp");
$images = $select->fetchAll();

?>

	<h2> Mes creations </h2>

	<ul class="display-images">
		<?php foreach ($images as $image) : ?>

			<li>
				<img class="img" src="<?php echo WEBROOT; ?>img/<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" width="100%"><br>
				| <a href="?delete=<?php echo $image['id'].'&'.csrf();?>" onclick="return('Sur sur sur ?')">Supprimer</a>
			</li>
		 <?php  endforeach; ?>
	</ul>
		

	<div class="paginate">
		<p><?php 
			if ($cp > 1) { 
				echo ' <a href="'. WEBROOT .'admin/my_creations.php?p='. ($cp - 1) . '">previous</a>'; 
			} ?> [ <?php echo $cp; ?> ] <?php
			if ($cp < $nb_page) {
				echo ' <a href="'. WEBROOT .'admin/my_creations.php?p='. ($cp + 1) . '">next</a>';
			}
		?></p>
	</div>

<?php include '../partials/footer.php'; ?>