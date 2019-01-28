<?php

require_once("plugins/includes.php");
require_once("controlers/utils.php");
session_start();

authVerif(false);

if (isset($_POST['email'])) {
    $db = dbConnect();
    $email = htmlentities($_POST['email']);

    $select = $db->prepare("SELECT * FROM users WHERE email=:email");
    $select->execute(array('email' => $email));
    $result = $select->fetchAll();
    if (count($result) > 0) {
        $user = $result[0];
        if ($user['confirm'] == 0)
            setMessageForm("Compte non confirmé, pensez à cliquer sur le lien dans le mail d'inscription.", 'error');
        else {
            $token = bin2hex(openssl_random_pseudo_bytes(64));
            $select = $db->prepare("UPDATE users SET token=:token WHERE username=:username AND email=:email");
            $select->execute(array('token' => $token, 'username' => $user['username'], 'email' => $email));
            mail("<".$email.">", "Réinitialisation du mot de passe", "Bonjour ".$user['username'].", votre demande a bien été prise en compte !\n\nMerci de cliquer sur ce lien pour réinitialiser votre mot de passe : http://127.0.0.1:8080/newpw.php?token=".$token."", $headers);
            setMessageForm("Un mail vient d'être envoyé.", 'success');
            header('Location: login.php');
        }
    }
    else {
        setMessageForm("Cet email n'est associé à aucun utilisateur connu.", 'error');
    }
}

$title = "Réinitialisation du mot de passe";
ob_start();

?>

<?php if (isset($_SESSION['messageForm']) && $_SESSION['messageForm']['type'] == 'error') { ?>

    <form class="ui form error" action="reset.php" method="POST">
        <?php echo extractMessageForm(); ?>
        <div class="field">
            <label>Email</label>
            <?php echo input('email', 'text'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php } else { ?>

    <form class="ui form" action="reset.php" method="POST">
        <div class="field">
            <label>Email</label>
            <?php echo input('email', 'text'); ?>
        </div>
        <button class="ui button teal right floated" type="submit">Valider</button>
    </form>

<?php }

$content = ob_get_clean();
require('templates/layout.php');

?>
