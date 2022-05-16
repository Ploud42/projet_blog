<?php
session_start();
if (isset($_SESSION['pseudo'], $_SESSION['pwd'])) {
    header('Location: ./welcome.php');
    die();
}
require './partials/header.php';
?>
<div class="text-center mt-3">
    <h1>Veuillez vous authentifier</h1>
    <form action="./login_check.php" method="post">
        <label class="form-label pb--2" for="pseudo"><strong> Pseudo : </strong></label>
        <p><input type="text" id="pseudo" name="pseudo" <?php
                                                        if (isset($_COOKIE['PSEUDO_USER']) && !empty($_COOKIE['PSEUDO_USER'])) {
                                                            echo 'value="' . $_COOKIE['PSEUDO_USER'] . '"';
                                                        }
                                                        ?> required="required"></p>

        <p><label for="pwd"><strong>Mot de passe : </strong></label></p>
        <input type="password" name="pwd" id="pwd" required="required">
        <p class="pt-2"><input type="checkbox" name="rememberMe"> Se souvenir de moi (pendant une semaine)</p>
        <input class="btn btn-secondary" type="submit" value="OK">
    </form>

    <h2>Vous n'avez pas de compte?</h2>
    <a href="./create_account.php">Créer un compte</a>
</div>
<?php
require './partials/footer.php';
?>