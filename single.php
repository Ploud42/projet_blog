<?php
require './functions.php';
if (isset($_GET['post_id']) && !empty($_GET['post_id']) && post_exists(htmlspecialchars($_GET['post_id']))) {
    $post_id = htmlspecialchars($_GET['post_id']);
    $post = get_post($post_id);
} else {
    header('Location: ./welcome.php');
    die();
}
/* $splitdate = explode(" ", $post['date']);
$date = $splitdate[0];
$hour = $splitdate[1]; */
require './partials/header.php';
include './partials/menu.php';
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    if (post_is_from_this_user($_SESSION['id'], $_GET['post_id']) || get_author_name($_SESSION['id']) == 'Admin')
        echo '<div class="text-end"><a class="text-primary" href="./edit_post.php?post_id=' . $_GET['post_id'] . '">Editer</a></div>';
}
echo "<h1>" . $post['title'] . "</h1>";
echo '<img class="img-fluid w-100 mh-25" src="' . $post['image'] . '" alt="image"/>';
echo '<p class="content">' . $post['content'] . '</p>';
echo '<p><a href="./author_posts.php?author_id=' . $post['author_id'] . '">' . get_author_name($post['author_id']) . '</a> date de publication : ' . time_to_fr($post['date']) . '</p>';
echo '<p>Catégorie : <a href="./category_posts.php?category_id=' . $post['category_id'] . '">' . get_category_name($post['category_id']) . '</a></p>';
$comments = get_comments_per_post($post_id);
?>
<div id="comm_div" class="list-group mt-3">
    <div>
        <span class="h4 titre_commentaires">Commentaires :</span>
        <span id="badge" class="badge bg-secondary mb-1"><?php echo count($comments) ?></span>
    </div>
    <div id="comments">
        <?php
        $i = 0;
        foreach ($comments as $comment) {
        ?>
            <div class="list-group-item list-group-item-action <?php if (($i % 2) == 0)
                                                                    echo 'darker-bg'
                                                                ?>">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><u><?php echo $comment['pseudo'] ?></u></h5>
                    <small><?php echo $comment['time'] ?></small>
                </div>
                <div>
                    <p class="mb-1"><?php echo $comment['content'] ?></p>
                    <?php if (get_author_name($_SESSION['id']) == 'Admin') {
                        echo '<div class="text-end"><a href="" class="text-primary">Effacer commentaire</a></div>';
                    }
                    ?>
                </div>
            </div>
        <?php
            $i++;
        } ?>
    </div>
</div>
<h4 class="my-1">Ajoutez votre commentaire : </h4>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" id="secret" value="<?php echo $post_id; ?>">
    <input type="text" class="form-control mb-1" placeholder="Votre pseudo" <?php
                                                                            if (isset($_SESSION['id']) && !empty($_SESSION['id']))
                                                                                echo 'value="' . get_author_name($_SESSION['id']) . '"';
                                                                            ?> id="pseudo_comm" name="pseudo_comm" required="required">
    <textarea name="comment" class="form-control" id="comment_txt" placeholder="Votre commentaire ici" rows="10" cols="30"></textarea>
    <input class="btn btn-primary mt-3" type="button" id="btn_post_comm" value="Poster">
</form>
<?php
require './partials/footer.php';
?>