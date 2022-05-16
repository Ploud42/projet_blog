<?php
require './functions.php';
if (isset($_POST['pseudo'], $_POST['pwd1'], $_POST['pwd2'], $_POST['mail'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['pwd1']) && !empty($_POST['pwd2']) && !empty($_POST['mail'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $pwd1 = htmlspecialchars($_POST['pwd1']);
        $pwd2 = htmlspecialchars($_POST['pwd2']);
        $mail = htmlspecialchars($_POST['mail']);
        if ($pwd1 == $pwd2) {
            $check_user = user_exists($pseudo, $pwd1);
            if (!$check_user) {
                add_user($pseudo, $pwd1, $mail);
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['pwd'] = $pwd1;
                $_SESSION['id'] = user_exists($pseudo, $pwd1);
                header('Location: ./welcome.php');
                die();
            } else if ($check_user == -1)
                echo '<div class="text-center pt-2"><p class="text-warning">Ce pseudo existe deja</p></div>';
            else
                echo '<div class="text-center pt-2"><p class="text-warning">Ce compte existe deja</p></div>';
        } else
            echo '<div class="text-center pt-2"><p class="text-warning">Les deux mots de passe ne correspondent pas</p></div>';
    } else
        echo '<div class="text-center pt-2"><p class="text-warning">Veuillez remplir les champs vides</p></div>';
}
include './partials/header.php';
?>
<div class="text-center mt-3">
    <h1>Création de compte</h1>
    <form action="" method="post">
        <p><strong>Pseudo :</strong></p>
        <input type="text" name="pseudo" required="required">
        <p><strong>Adresse email :</strong></p>
        <input type="email" name="mail" required="required">
        <p><strong>Mot de passe :</strong></p>
        <input type="password" name="pwd1" required="required">
        <p><strong>Verification du mot de passe :</strong></p>
        <input type="password" name="pwd2" required="required"></br>
        <input class="mt-3" type="submit" value="OK">
    </form>
</div>
<?php
include './partials/footer.php'
?>