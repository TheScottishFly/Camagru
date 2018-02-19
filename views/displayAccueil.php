<?php $title = "Camagru - Instagram-like"; ?>

<?php ob_start(); ?>
h1
	| Accueil
p
	| Test

<?php $content = ob_get_clean(); ?>
<?php require("layout.pug"); ?>
