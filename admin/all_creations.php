<?php 
include '../lib/includes.php';
include '../partials/admin_header.php';

// GET ALL IMAGES
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

// Get result from db
$select = $db->query("SELECT * FROM images ORDER BY pub_date DESC LIMIT $first, $ppp");
$images = $select->fetchAll();

?>

	<h2> Les plus récents </h2>

	<ul class="display-images">
		<?php foreach ($images as $image) : ?>
			<li>
				<img class="img" src="<?php echo WEBROOT; ?>img/<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" width="100%"><br>
				[<?php echo $image['like_count']; ?>]  <a href="<?php echo WEBROOT . 'admin/plus_like.php?id='. $image['id'] ?>">Likez</a> | <a href="<?php echo WEBROOT . 'admin/comment.php?id='. $image['id'] ?>">Commenter</a>
		 	</li>
		 <?php  endforeach; ?>
	</ul>

	<div class="paginate">
		<p><?php 
			if ($cp > 1) { 
				echo ' <a href="'. WEBROOT .'admin/all_creations.php?p='. ($cp - 1) . '">previous</a>'; 
			} ?> [ <?php echo $cp; ?> ] <?php
			if ($cp < $nb_page) {
				echo ' <a href="'. WEBROOT .'admin/all_creations.php?p='. ($cp + 1) . '">next</a>';
			}
		?></p>
	</div>
		

<?php include '../partials/footer.php'; ?>