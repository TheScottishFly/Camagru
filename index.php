<?php

require_once("controlers/utils.php");
require_once("controlers/get_images.php");

if (!isset($_GET['page']))
    $page = 1;
else
    $page = $_GET['page'];
$images = getAllImages()->fetchAll();
$imgarray = array();
for ($i = $page * 5 - 5; $i < $page * 5; $i++)
    if (isset($images[$i]))
        array_push($imgarray, $images[$i]);
$db = dbConnect();
$result = $db->query("SELECT * FROM images");
$count = count($result->fetchAll());
if ($count % 5 == 0)
    $max_page = intval($count / 5);
else
    $max_page = intval($count / 5) + 1;
if ($page > $max_page)
    header('Location: index.php?page=' . $max_page);
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

<div class="ui grid center aligned">
    <div class="ui pagination menu">
        <?php if ($page != 1) {
            for ($i = 1; $i < $page; $i++) {?>
                <a href="?page=<?php echo $i; ?>" class="item">
                    <?php echo $i; ?>
                </a>
        <?php } } ?>
        <a href="#" class="active item">
            <?php echo $page; ?>
        </a>
        <?php if ($page < $max_page) {
            for ($i = $page + 1; $i <= $max_page; $i++) {?>
                <a href="?page=<?php echo $i; ?>" class="item">
                    <?php echo $i; ?>
                </a>
        <?php } } ?>
    </div>
</div>

<div class="ui grid home-list">
    <div class="doubling five column row list-image">
        <?php foreach ($imgarray as $img) { ?>
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
