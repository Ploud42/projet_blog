<?php
session_start();
if (isset($_SESSION['pseudo'], $_SESSION['pwd'])) {
    session_destroy();
}
require './partials/header.php';
?>
<div class="text-center mt-3">
    <h1>Déconnexion</h1>
    <p>Vous venez de vous déconnecter, au revoir !</p>
    <a href="./welcome.php">Retour au site</a>
</div>
<?php
require './partials/footer.php';
?>