<?php

include_once "controlers/get_images.php";

$images = getAllImages();
$title = "Accueil";
ob_start();

?>

<div class="ui relaxed grid home-list">
    <div class="doubling six column row list-image">
        <?php while ($img = $images->fetch()) { ?>
            <div class="column">
                <a href=<?= "?img=".$img['id'] ?>>
                    <img src="resources/images/instagram.png"/>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<?php

$content = ob_get_clean();
require('templates/layout.php');

?>
