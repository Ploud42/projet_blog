<?php
require './functions.php';
if (isset($_POST['pseudo'], $_POST['pwd'], $_POST['rememberMe']) && user_exists($_POST['pseudo'], $_POST['pwd']) && $_POST['rememberMe'] == 'on') {
    setcookie(
        'PSEUDO_USER',
        $_POST['pseudo'],
        [
            'expires' => time() + 3600 * 24 * 7,
            'secure' => true,
            'httponly' => true,
        ]
    );
}
include './partials/header.php';
?>
<h1>Espace de connexion</h1>
<?php
if (isset($_SESSION['pseudo'], $_SESSION['pwd'])) {
    echo "Bonjour <strong>" . $_SESSION['pseudo'] . "</strong>, bienvenue sur notre site.</br>";
    echo '<a href="./create_post.php">Créer un article</a></br>';
    echo '<a href="./author_posts.php?author_id=' . $_SESSION['id'] . '">Acceder à vos articles</a></br>';
    echo '<a href="./login_deco.php">Se déconnecter</a>';
} else if (isset($_POST['pseudo'], $_POST['pwd'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $pwd = htmlspecialchars($_POST['pwd']);
    $result = user_exists($pseudo, $pwd);
    if (!$result) {
        echo "Cet utilisateur n'existe pas</br>";
        echo '<a href="./login_form.php">Retour au formulaire de connexion</a>';
    } else if ($result == -1) {
        echo "Mauvais mot de passe</br>";
        echo '<a href="./login_form.php">Retour au formulaire de connexion</a>';
    } else {
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['pwd'] = $pwd;
        $_SESSION['id'] = $result;
        header('Location: ./welcome.php');
        die();
        /*         echo "Bienvenue, <strong>" . $pseudo . "</strong>. Vous êtes sur l'interface securisée.</br>";
        echo '<a href="./create_post.php">Créer un article</a></br>';
        echo '<a href="./author_posts.php?author_id=' . $result . '">Acceder à vos articles</a></br>';
        echo '<a href="./login_deco.php">Se déconnecter</a>'; */
    }
} else {
    echo "Veuillez vous vous identifier pour vous connecter.</br>";
    echo '<a href="./login_form.php">Remplissez le formulaire ici</a>';
}
include './partials/footer.php'
?>