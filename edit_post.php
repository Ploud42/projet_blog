<?php
require './functions.php';
if (isset($_POST['title'], $_POST['content'], $_POST['category']) && !empty($_POST['title']) && !empty($_POST['content'])) {
    if (isset($_SESSION['id']) && !empty($_SESSION['id']) && post_is_from_this_user($_SESSION['id'], $_GET['post_id'])) {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $category_id = htmlspecialchars($_POST['category']);
        $post_id = htmlspecialchars($_GET['post_id']);
        print_r($_FILES);
        if (isset($_FILES) && !empty($_FILES) && !empty($_FILES['img']['tmp_name'])) {
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
                $file = './asset/img/' . $uniqueName . '.' . $extension;
                move_uploaded_file($tmpName, $file);
                unlink($post['image']);
            } else {
                echo 'alert("Une erreur est survenue")';
                header('Location: ./create_post.php');
                die();
            }
        } else {
            $post = get_post($post_id);
            $file = $post['image'];
        }
        edit_post($post_id, $title, $file, $content, $category_id);
        header('Location: ./single.php?post_id=' . $post_id);
        die();
    } else {
        header('Location: ./welcome.php');
        die();
    }
}
if (isset($_GET['post_id'], $_SESSION['id']) && !empty($_GET['post_id']) && !empty($_SESSION['id']) && post_exists(htmlspecialchars($_GET['post_id'])) && post_is_from_this_user(htmlspecialchars($_SESSION['id']), htmlspecialchars($_GET['post_id']))) {
    $post_id = htmlspecialchars($_GET['post_id']);
    $post = get_post($post_id);
} else {
    header('Location: ./welcome.php');
    die();
}
$categories = get_categories();
require './partials/header.php';
include './partials/menu.php';
?>
<div class="create_post">
    <h1>Editer l'article</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title" class="form-label"><strong>Titre :</strong></label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title'] ?>" required="required">
        <label for="content" class="form-label"><strong>Contenu de l'article :</strong></label>
        <textarea name="content" class="form-control" id="content" rows="10" cols="40"><?php echo $post['content'] ?></textarea>
        <label for="img" class="form-label"><strong>Image :</strong></label>
        <input type="file" class="form-control" id="img" name="img">
        <label for="category" class="form-label"><strong>Categorie :</strong></label>
        <select class="form-select" id="category" aria-label="Default select example" name="category" required>
            <option value="">Catégorie</option>
            <?php
            foreach ($categories as $category) {
                if ($category['id'] == $post['category_id']) {
                    echo '<option value="' . $category['id'] . ' " selected>' . $category['name'] . '</option>';
                } else
                    echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
            }
            ?>
        </select></br>
        <input class="btn btn-primary" type="submit" value="Editer">
        <a class="btn btn-primary" href="./delete_post.php?post_id=<?php echo $post_id ?>">Supprimer</a>
    </form>
</div>
<?php
require './partials/footer.php';
?>