<?php
require './functions.php';
if (isset($_POST['title'], $_POST['content'], $_POST['category'], $_FILES['img']) && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_FILES['img'])) {
    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $category_id = htmlspecialchars($_POST['category']);
        $tmpName = $_FILES['img']['tmp_name'];
        $name = basename($_FILES['img']['name']);
        $size = $_FILES['img']['size'];
        $error = $_FILES['img']['error'];
        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        /* $maxSize = 4000000; Pour limiter la taille des fichiers uploadés */
        if (in_array($extension, $extensions) /* && $size <= $maxSize */ && $error == 0) {
            $uniqueName = uniqid('', true);
            $file = $uniqueName . "." . $extension;
            move_uploaded_file($tmpName, './asset/img/' . $file);
        } else {
            echo 'alert("Une erreur est survenue")';
            header('Location: ./create_post.php');
            die();
        }
        $post_id = create_post($title, $content, './asset/img/' . $file, $_SESSION['id'], $category_id);
        header('Location: ./single.php?post_id=' . $post_id);
        die();
    } else if (!isset($_SESSION['id'])) {
        header('Location: ./welcome.php');
        die();
    }
}
$categories = get_categories();
require './partials/header.php';
include './partials/menu.php';
?>
<div class="create_post">
    <h1>Création d'article</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title" class="form-label"><strong>Titre :</strong></label>
        <input type="text" class="form-control" id="title" name="title" required="required">
        <label for="content" class="form-label"><strong>Contenu de l'article :</strong></label>
        <textarea name="content" class="form-control" id="content" rows="10" cols="40"></textarea>
        <label for="img" class="form-label"><strong>Image :</strong></label>
        <input type="file" class="form-control" id="img" name="img">
        <label for="category" class="form-label"><strong>Categorie :</strong></label>
        <select class="form-select" id="category" aria-label="Default select example" name="category" required>
            <option value="">Catégorie</option>
            <?php
            foreach ($categories as $category) {
                echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
            }
            ?>
        </select></br>
        <input class="btn btn-primary" type="submit" value="Poster">
    </form>
</div>
<?php
require './partials/footer.php';
?>