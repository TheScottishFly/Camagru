<?php

$title = "Accueil - Camagru";
ob_start();

?>

<h1>

<?php

$content = ob_get_clean();
require('layout.php');

?>
