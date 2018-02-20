<?php

include_once "plugins/includes.php";
include_once "controlers/utils.php";

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])){
    if ($_POST['password1'] != $_POST['password2']) {
        setMessageForm("Le mot de passe ne correspond pas, merci de corriger.", 'error');
    }
    else {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $db = dbConnect();
            $username = $db->quote($_POST['username']);
            $email = $db->quote($_POST['email']);
            $password = $db->quote(sha1($_POST['password1']));

            $select = $db->query("SELECT * FROM users WHERE username=$username OR email=$email");
            if (count($select->fetchALL()) == 0) {
                $req = $db->prepare("INSERT INTO users(username, password, email) VALUES(:username, :email, :password)");
                $req->execute(array('username' => $username, 'email' => $email, 'password' => $password));
                mail($_POST['email'], "Inscription reussie", "Bonjour ".$_POST['username'].", votre inscription est validée !");
                setMessageForm("Vous pouvez maintenant vous connecter sur Camagru !", 'success');
                header('Location: login.php?success=true');
            }
            else {
                setMessageForm("Ce nom d'utilisateur ou cet email sont déjà utilisés.", 'error');
            }
        }
        else {
            setMessageForm("Cet email n'est pas valide, merci de corriger.", 'error');
        }
    }
}

$title = "Inscription";
ob_start();

?>

<?php if (isset($_SESSION['messageForm']) && $_SESSION['messageForm']['type'] == 'error') { ?>

    <form class="ui form error" action="register.php" method="POST">
        <?php echo extractMessageForm(); ?>
        <div class="field">
            <label>Nom d'utilisateur</label>
            <?php echo input('username', 'text'); ?>
        </div>
        <div class="field">
            <label>Email</label>
            <?php echo input('email', 'text'); ?>
        </div>
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

    <form class="ui form" action="register.php" method="POST">
        <div class="field">
            <label>Nom d'utilisateur</label>
            <?php echo input('username', 'text'); ?>
        </div>
        <div class="field">
            <label>Email</label>
            <?php echo input('email', 'text'); ?>
        </div>
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
