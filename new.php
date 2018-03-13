<?php

require_once("controlers/utils.php");
require_once("plugins/includes.php");
session_start();

authVerif(true);

if (isset($_POST['title']) && isset($_POST['photo'])){
    $db = dbConnect();
    $title = htmlentities($_POST['title']);
    $filename =  time() . '.png';
    $filepath = 'resources/photos/';
    $alpha = 'resources/alphas/';
    $select = $db->prepare("INSERT INTO images(name, title, author_id, nb_like) VALUES(:name, :title, :uid, :nb_like)");
    $select->execute(array('name' => $filename, 'title' => $title, 'uid' => $_SESSION['uid'], 'nb_like' => 0));
    $parts = explode(',', $_POST['photo']);
    $data = $parts[1];
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    file_put_contents($filepath.$filename, $data);
    $im = imagecreatefrompng($filepath.$filename);
    $alpha = imagecreatefrompng($alpha .$_POST['alpha'].'.png');
    imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);
    imagepng($im,  $filepath.$filename);
    imagedestroy($im);
    $select = $db->prepare("SELECT * FROM images WHERE title=:title AND author_id=:uid");
    $select->execute(array('title' => $title, 'uid' => $_SESSION['uid']));
    $result = $select->fetchAll();
    if (count($result) > 0) {
        $image = $result[0];
        header('Location: image.php/' . $image['id']);
    }
    else {
        header('Location: new.php');
        setMessageForm("Impossible d'enregistrer l'image.", 'error');
    }
}

$title = "Nouvelle image";
ob_start();

?>

<div class="ui grid">
    <div class="sixteen wide column center aligned">
        <video autoplay="true" id="video">
        </video>
        <br />
        <br />
        <button type="button" id="takebutton" class="ui button teal">
            <i class="fas fa-camera"></i>
        </button>
        <br />
        <br />
        <canvas id="canvas"></canvas>
    </div>
    <div class="sixteen wide column center aligned">
        <form action="new.php" class="ui form" method="POST" enctype="multipart/form-data">
            <ul class="selection">
                <li><label><input type="radio" name="alpha" value="alpha1" checked="checked"><img src=<?= "/resources/alphas/alpha1.png" ?>></label></li>
                <li><label><input type="radio" name="alpha" value="alpha2"><img src=<?= "/resources/alphas/alpha2.png" ?>></label></li>
            </ul>
            <input type="hidden" name="photo" id="photo">
            <?php echo input('title', 'text', "Titre"); ?>
            <br />
            <br />
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