<?php

require_once("controlers/utils.php");
require_once("plugins/includes.php");
require_once("controlers/get_images.php");

authVerif(true);

if (isset($_POST['title']) && isset($_POST['photo'])){
    $db = dbConnect();
    $title = htmlentities($_POST['title']);
    $filename =  time() . '.png';
    $filepath = 'resources/photos/';
    $alpha = 'resources/alphas/';
    $select = $db->prepare("INSERT INTO images(name, title, author_id, nb_like) VALUES(:name, :title, :uid, :nb_like)");
    $select->execute(array('name' => $filename, 'title' => $title, 'uid' => $_SESSION['uid'], 'nb_like' => 0));
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['photo']));
    file_put_contents($filepath.$filename, $data);
    $select = $db->prepare("SELECT * FROM images WHERE title=:title AND author_id=:uid");
    $select->execute(array('title' => $title, 'uid' => $_SESSION['uid']));
    $result = $select->fetchAll();
    if (count($result) > 0) {
        $id = $result[0]['id'];
        header("Location: image.php?img=$id");
    }
    else {
        header('Location: new.php');
        setMessageForm("Impossible d'enregistrer l'image.", 'error');
    }
}

$images = getImagesByAuth($_SESSION['uid']);
$title = "Nouvelle image";
ob_start();

?>

<div class="ui grid">
    <div class="twelve wide column center aligned">
        <video autoplay="true" id="video">
        </video>
        <br/>
        <br/>
        <button type="button" id="takebutton" class="ui button teal">
            <i class="fas fa-camera"></i>
        </button>
        <br/>
        <br/>
        <canvas id="canvas"></canvas>
    </div>
    <div class="four wide column center aligned ui grid new-list">
        <div class="doubling two column row list-image">
            <?php while ($img = $images->fetch()) { ?>
                <div class="column">
                    <a href=<?= "image.php?img=" . $img['id'] ?>>
                        <img src=<?= "/resources/photos/" . $img['name'] ?>/>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="sixteen wide column center aligned">
        <form action="new.php" class="ui form" method="POST" enctype="multipart/form-data" id="postform">
            <ul class="selection">
                <li><label><input type="radio" name="alpha" class="alpha" value="alpha1" checked="checked"><img
                                src=<?= "/resources/alphas/alpha1.png" ?>></label></li>
                <li><label><input type="radio" name="alpha" class="alpha" value="alpha2"><img
                                src=<?= "/resources/alphas/alpha2.png" ?>></label></li>
                <li><label><input type="radio" name="alpha" class="alpha" value="alpha2"><img
                                src=<?= "/resources/alphas/alpha3.png" ?>></label></li>
            </ul>
            <input type="hidden" name="photo" id="photo">
            <?php echo input('title', 'text', "Titre"); ?>
            <br/>
            <br/>
            <button type="submit" class="ui button green">
                <i class="fas fa-save"></i>
            </button>
        </form>
    </div>
</div>

<script src="../resources/js/webcam.js" type="text/javascript"></script>

<?php

$content = ob_get_clean();
require('templates/layout.php');

?>