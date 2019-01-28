<?php

require_once("plugins/includes.php");
require_once("controlers/utils.php");
session_start();

authVerif(false);
$db = dbConnect();

if (isset($_POST['token']) && isset($_POST['password1']) && isset($_POST['password2'])) {
    $token = htmlentities($_POST['token']);
    if ($_POST['password1'] != $_POST['password2']) {
        setMessageForm("Le mot de passe ne correspond pas, merci de corriger.", 'error');
    }
    else if (!(preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', $_POST['password1'])))
    {
        setMessageForm("Le mot de passe n'est pas securise, minimum 8 caracteres et un chiffre.", 'error');
    }
    else {
        $password = htmlentities(sha1($_POST['password1']));

        $select = $db->prepare("UPDATE users SET password=:password, token=0 WHERE token=:token");
        $select->execute(array('password' => $password, 'token' => $token));
        setMessageForm("Mot de passe réinitialisé !", 'success');
        header('Location: login.php');
    }
}
elseif (isset($_GET['token'])) {
    $token = htmlentities($_GET['token']);

    $select = $db->prepare("SELECT * FROM users WHERE token=:token");
    $select->execute(array('token' => $token));
    $result = $select->fetchAll();
    if (count($result) > 0) {
        $user = $result[0];
    }
    else {
        setMessageForm("Ce token ne correspond à rien.", 'error');
        header("Location: login.php");
    }
}
else {
    header('Location: login.php');
}

$title = "Nouveau mot de passe";
ob_start();

?>

<?php if (isset($_SESSION['messageForm']) && $_SESSION['messageForm']['type'] == 'error') { ?>

    <form class="ui form error" action="newpw.php" method="POST">
        <?php echo extractMessageForm(); ?>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="field">
            <label>Mot de passe</label>
            <?php echo input('password1', 'password'); ?>
            <br/>
            <br/>
            <label>Confirmation du mot de passe</label>
            <?php echo input('password2', 'password'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php } else { ?>

    <form class="ui form" action="newpw.php" method="POST">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="field">
            <label>Mot de passe</label>
            <?php echo input('password1', 'password'); ?>
            <br/>
            <br/>
            <label>Confirmation du mot de passe</label>
            <?php echo input('password2', 'password'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php }

$content = ob_get_clean();
require('templates/layout.php');

?>
