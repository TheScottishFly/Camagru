<?php

require_once("plugins/includes.php");
require_once("controlers/utils.php");
session_start();

authVerif(false);

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])){
    if ($_POST['password1'] != $_POST['password2']) {
        setMessageForm("Le mot de passe ne correspond pas, merci de corriger.", 'error');
    }
    else if (!(preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', $_POST['password1'])))
    {
        setMessageForm("Le mot de passe n'est pas securise, minimum 8 caracteres et un chiffre.", 'error');
    }
    else if (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
        setMessageForm("L'email n'est pas valide.", 'error');
    }
    else {
        $db = dbConnect();
        $username = htmlentities($_POST['username']);
        $email = htmlentities($_POST['email']);
        $password = htmlentities(sha1($_POST['password1']));

        $select = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $select->execute(array($username, $email));
        if (count($select->fetchALL()) == 0) {
            $token = bin2hex(random_bytes(64));
            $req = $db->prepare("INSERT INTO users(username, password, email, confirm, token) VALUES(:username, :password, :email, FALSE, :token)");
            $req->execute(array('username' => $username, 'password' => $password, 'email' => $email, 'token' => $token));
            mail($_POST['email'], "Inscription reussie", "Bonjour ".$_POST['username'].", votre inscription est validee !\n\nMerci de confirmer votre compte : http://localhost:8000/confirm.php?token=".$token."", $headers);
            setMessageForm("Vous pouvez maintenant vous connecter sur Camagru !", 'success');
            header('Location: login.php');
        }
        else {
            setMessageForm("Ce nom d'utilisateur ou cet email sont déjà utilisés.", 'error');
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
