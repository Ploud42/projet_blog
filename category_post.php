<?php
require './functions.php';
if (isset($_GET['author_id']) && !empty($_GET['author_id'])) {
    $author_id = htmlspecialchars($_GET['author_id']);
    $author_posts = get_posts_by_author($author_id);
} else {
    header('Location: ./login_check.php');
    die();
}
require './partials/header.php';
echo '<div class="container">';
echo '<h2>Articles de ' . get_author_name($author_id) . ' : </h2>';
foreach ($author_posts as $author_post) {
    $text = truncate_text($author_post['content']);
?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo $author_post['image']; ?>" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo '<a href="./single.php?post_id=' . $author_post['id'] . '">' . $author_post['title'] . '</a>' ?></h5>
                    <p class="card-text"><?php echo $text ?></p>
                    <p class="card-text"><small class="text-muted"><?php echo 'Publié le ' . time_to_fr($author_post['date']) . ' par <a href="./author_posts.php?author_id=' . $author_id . '">' . get_author_name($author_id) . '</a>' ?></small></p>
                </div>
            </div>
        </div>
    </div>
<?php
}
echo "</div>";
require './partials/footer.php';
?>