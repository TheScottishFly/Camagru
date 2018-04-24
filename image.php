<?php

include_once "controlers/get_images.php";
include_once "controlers/utils.php";
require_once("plugins/includes.php");

if (isset($_GET["img"])) {
    $img = getOneImage($_GET["img"]);
    if (!isset($img["id"])) {
        header("Location: /");
    }
}
else
    header("Location: /");

if (isset($_POST['comment'])){
    $db = dbConnect();
    $img_id = substr($_POST['img'], 0, -1);
    $select = $db->prepare("INSERT INTO comments(author, date, text, image_id) VALUES(:author, :date, :text, :image_id)");
    $select->execute(array('author' => $_SESSION['username'], 'date' => date("Y-m-d H:i:s"), 'text' => htmlentities($_POST['comment']), 'image_id' => $img_id));
    $url = "image.php?img=$img_id";
    header("Location: ".$url);
}

$title = $img["title"] . ' - Image';
$db = dbConnect();
$req = $db->prepare("SELECT * FROM comments WHERE image_id = ? ORDER BY date DESC");
$req->execute(array($_GET["img"]));
$comments = $req;
ob_start();

?>

<div class="ui grid">
    <div class="sixteen wide column center aligned">
        <img class="image-main" src=<?= "/resources/photos/".$img['name'] ?>/>
        <form action="image.php" class="ui form" method="POST" id="postform">
            <input type="hidden" name="img" id="img" value=<?= $_GET["img"] ?>/>
            <?php echo input('comment', 'text', "Commentaire"); ?>
            <br />
            <br />
            <button type="submit" class="ui button green">
                <i class="fas fa-check"></i>
            </button>
        </form>
    </div>
    <div class="sixteen wide column center aligned">
        <br />
        <div class="ui relaxed divided list">
            <?php while ($comment = $comments->fetch()) { ?>
                <div class="item">
                    <div class="header"><?= $comment['date'] . " - " . $comment["author"] ?></div>
                    <p><?= $comment['text'] ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php

$content = ob_get_clean();
require('templates/layout.php');

?>
