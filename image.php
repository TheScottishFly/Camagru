<?php

include_once "controlers/get_images.php";

if (isset($_GET["img"]))
    $img = getOneImage($_GET["img"]);
else
    header("Location: /");

$title = $img["title"] . ' - Image';
ob_start();

?>

<img src=<?= "/resources/photos/".$img['name'] ?>/>

<?php

$content = ob_get_clean();
require('templates/layout.php');

?>
