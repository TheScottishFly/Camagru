<div class="ui massive menu header-menu">
    <img src="../resources/images/logo.png" id="logo" class="mobile hidden" />
    <img src="../resources/images/logomobile.png" id="logo" class="mobile only" />
    <a class="item" href="/" title="Accueil">
        <i class="fas fa-home"></i>
        <p class="mobile hidden">Accueil</p>
    </a>
    <?php if (!(isset($_SESSION['uid']))) { ?>
        <div class="right menu">
            <a class="ui item" href="login.php" title="Connexion">
                <i class="fas fa-sign-in-alt"></i>
                <p class="mobile hidden">Connexion</p>
            </a>
            <a class="ui item" href="register.php" title="Inscription">
                <i class="fas fa-user-plus"></i>
                <p class="mobile hidden">Inscription</p>
            </a>
        </div>
    <?php } else { ?>
        <a class="item" href="/new.php" title="Nouvelle image">
            <i class="fas fa-camera-retro"></i>
            <p class="mobile hidden">Nouvelle image</p>
        </a>
        <div class="right menu">
            <a class="ui item" href="account.php" title="Compte">
                <i class="fas fa-user"></i>
                <p class="mobile hidden"><?php echo $_SESSION['username']; ?></p>
            </a>
            <a class="ui item" href="logout.php" title="Déconnexion">
                <i class="fas fa-sign-out-alt"></i>
                <p class="mobile hidden">Déconnexion</p>
            </a>
        </div>
    <?php } ?>
</div>
