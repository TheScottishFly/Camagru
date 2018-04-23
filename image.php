<?php

include_once "controlers/get_images.php";

if (isset($_GET["img"]))
    $image = getOneImage($_GET["img"]);
else
    header("Location: /");

$title = "Image n°" . $image["id"];
ob_start();

?>

<h1><?= $image ?></h1>

<?php

$content = ob_get_clean();
require('templates/layout.php');

?>
