<?php
require './functions.php';
if (isset($_POST['confirm'], $_SESSION['id'], $_GET['post_id']) && !empty($_GET['post_id']) && !empty($_POST['confirm']) && !empty($_SESSION['id']) && post_exists(htmlspecialchars($_GET['post_id'])) && post_is_from_this_user(htmlspecialchars($_SESSION['id']), htmlspecialchars($_GET['post_id'])) && $_POST['confirm'] == 1) {
    $post_id = htmlspecialchars($_GET['post_id']);
    delete_post($post_id);
    header('Location: ./author_posts.php?author_id=' . $_SESSION['id']);
    die();
}
if (isset($_GET['post_id'], $_SESSION['id']) && !empty($_GET['post_id']) && !empty($_SESSION['id']) && post_exists(htmlspecialchars($_GET['post_id'])) && post_is_from_this_user(htmlspecialchars($_SESSION['id']), htmlspecialchars($_GET['post_id']))) {
    $post_id = htmlspecialchars($_GET['post_id']);
    $post = get_post($post_id);
} else {
    header('Location: ./welcome.php');
    die();
}
require './partials/header.php';
include './partials/menu.php';
?>
<h2>Etes-vous sûr de vouloir supprimer cet article?</h2>
<form action="" method="POST">
    <input type="number" value="1" id="delete_input" name="confirm">
    <input class="btn btn-primary" type="submit" value="Supprimer">
    <a class="btn btn-primary" href="./edit_post.php?post_id=<?php echo $post_id ?>">Retour</a>
</form>
<?php
require './partials/footer.php';
?>