<?php

require_once("plugins/includes.php");
require_once("controlers/utils.php");
session_start();

authVerif(false);

if (isset($_POST['username']) && isset($_POST['password'])){
    $db = dbConnect();
    $username = htmlentities($_POST['username']);
    $password = htmlentities(sha1($_POST['password']));

    $select = $db->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
    $select->execute(array('username' => $username, 'password' => $password));
    $result = $select->fetchAll();
    if (count($result) > 0) {
        $user = $result[0];
        if ($user['confirm'] == 1) {
            $_SESSION['uid'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user'] = $user;
            header('Location: index.php');
        }
        elseif ($user['confirm'] == 0)
            setMessageForm("Compte non confirmé, pensez à cliquer sur le lien dans le mail d'inscription.", 'error');
    }
    else {
        setMessageForm("Echec d'authentification.", 'error');
    }
}

$title = "Connexion";
ob_start();

?>

<?php if (isset($_SESSION['messageForm']) && $_SESSION['messageForm']['type'] == 'error') { ?>

    <form class="ui form error" action="login.php" method="POST">
        <?php echo extractMessageForm(); ?>
        <div class="field">
            <label>Nom d'utilisateur</label>
            <?php echo input('username', 'text'); ?>
        </div>
        <div class="field">
            <label>Mot de passe</label>
            <?php echo input('password', 'password'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php } elseif (isset($_SESSION['messageForm']) && $_SESSION['messageForm']['type'] == 'success') { ?>

    <form class="ui form success" action="login.php" method="POST">
        <?php echo extractMessageForm(); ?>
        <div class="field">
            <label>Nom d'utilisateur</label>
            <?php echo input('username', 'text'); ?>
        </div>
        <div class="field">
            <label>Mot de passe</label>
            <?php echo input('password', 'password'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php } else { ?>

    <form class="ui form" action="login.php" method="POST">
        <div class="field">
            <label>Nom d'utilisateur</label>
            <?php echo input('username', 'text'); ?>
        </div>
        <div class="field">
            <label>Mot de passe</label>
            <?php echo input('password', 'password'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php }

$content = ob_get_clean();
require('templates/layout.php');

?>
