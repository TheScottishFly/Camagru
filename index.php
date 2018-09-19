<?php

require_once("controlers/get_images.php");

$images = getAllImages();
$title = "Accueil";
ob_start();

if (isset($_SESSION['messageForm'])) {
    if ($_SESSION['messageForm']['type'] == 'error') { ?>

    <form class="ui form error">
        <?php echo extractMessageForm(); ?>
    </form>

<?php } else { ?>

    <form class="ui form success">
        <?php echo extractMessageForm(); ?>
    </form>

<?php } } ?>

<div class="ui grid home-list">
    <div class="doubling five column row list-image">
        <?php while ($img = $images->fetch()) { ?>
            <div class="column column-photo">
                <a href=<?= "image.php?img=".$img['id'] ?>>
                    <img src=<?= "/resources/photos/".$img['name'] ?>/>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<?php

$content = ob_get_clean();
require('templates/layout.php');

?>
