<?php

require_once("controlers/utils.php");
require_once("plugins/includes.php");
require_once("controlers/get_images.php");

authVerif(true);

$db = dbConnect();
$err = 0;

if (isset($_POST['username'])) {
    $username = htmlentities($_POST['username']);
    $select = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
    $select->execute(array($username, $_SESSION["uid"]));
    $_SESSION['username'] = $username;
    $_SESSION['user']['username'] = $username;
}
if ($err == 0 && isset($_POST['email'])) {
    if (isset($_POST['email']) && !(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
        setMessageForm("L'email n'est pas valide.", 'error');
        $err = 1;
    }
    if ($err == 0) {
        $email = htmlentities($_POST['email']);
        $select = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
        $select->execute(array($email, $_SESSION["uid"]));
    }
    $_SESSION['user']['email'] = $email;
}
if ($err == 0 && isset($_POST['password1']) && isset($_POST['password2']) && strlen($_POST['password1']) > 7 && strlen($_POST['password2']) > 7) {
    if ($_POST['password1'] != $_POST['password2']) {
        setMessageForm("Le mot de passe ne correspond pas, merci de corriger.", 'error');
        $err = 1;
    }
    if ($err == 0 && isset($_POST['password1']) && !(preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', $_POST['password1'])))
    {
        setMessageForm("Le mot de passe n'est pas securise, minimum 8 caracteres et un chiffre.", 'error');
        $err = 1;
    }
    if ($err == 0) {
        $password = htmlentities(sha1($_POST['password1']));
        $select = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $select->execute(array($password, $_SESSION["uid"]));
    }
}
if ($err == 0) {
    if (isset($_POST['mail_comment']) && $_POST['mail_comment'] == 'mail_comment') {
        $select = $db->prepare("UPDATE users SET mail_comment = 1 WHERE id = ?");
        $select->execute(array($_SESSION["uid"]));
        $_SESSION['user']['mail_comment'] = 1;
    } else {
        $select = $db->prepare("UPDATE users SET mail_comment = 0 WHERE id = ?");
        $select->execute(array($_SESSION["uid"]));
        $_SESSION['user']['mail_comment'] = 0;
    }
}

$title = "Votre compte";
ob_start();

?>

<div class="ui grid">
    <div class="sixteen wide column center aligned">
        Statut :
        <?php if ($_SESSION['user']['confirm'] == 1) { ?>
            <div class="ui image green label">
                Confirmé
            </div>
        <?php } else { ?>
            <div class="ui image red label">
                Non confirmé
            </div>
        <?php } ?>
    </div>
</div>

<?php if (isset($_SESSION['messageForm']) && $_SESSION['messageForm']['type'] == 'error') { ?>

<form class="ui form error" action="account.php" method="POST">
    <?php echo extractMessageForm(); ?>
    <div class="field">
        <label>Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo $_SESSION["username"] ?>">
    </div>
    <div class="field">
        <label>Mot de passe</label>
        <input type="password" id="password1" name="password1">
    </div>
    <div class="field">
        <label>Confirmation du mot de passe</label>
        <input type="password" id="password2" name="password2">
    </div>
    <div class="field">
        <label>Email</label>
        <input type="text" id="email" name="email" value="<?php echo $_SESSION["user"]["email"] ?>">
    </div>
    <div class="field">
        <label>Mail commentaire</label>
        <input type="checkbox" id="mail_comment" name="mail_comment" value="mail_comment" <?php if ($_SESSION["user"]["mail_comment"] == 1) {echo 'checked';} ?>>
    </div>
    <button class="ui button teal right floated" type="submit">Valider</button>
</form>

<?php } else { ?>

<form class="ui form" action="account.php" method="POST">
    <div class="field">
        <label>Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo $_SESSION["username"] ?>">
    </div>
    <div class="field">
        <label>Mot de passe</label>
        <input type="password" id="password1" name="password1">
    </div>
    <div class="field">
        <label>Confirmation du mot de passe</label>
        <input type="password" id="password2" name="password2">
    </div>
    <div class="field">
        <label>Email</label>
        <input type="text" id="email" name="email" value="<?php echo $_SESSION["user"]["email"] ?>">
    </div>
    <div class="field">
        <label>Mail commentaire</label>
        <input type="checkbox" id="mail_comment" name="mail_comment" value="mail_comment" <?php if ($_SESSION["user"]["mail_comment"] == 1) {echo 'checked';} ?>>
    </div>
    <button class="ui button teal right floated" type="submit">Valider</button>
</form>

<?php }

$content = ob_get_clean();
require('templates/layout.php');

?>