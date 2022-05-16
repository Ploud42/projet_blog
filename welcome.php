<?php
require './functions.php';
require './partials/header.php';
include './partials/menu.php';
$posts = get_x_posts(0);
echo '<h2>Derniers articles : </h2>';
foreach ($posts as $post) {
    $text = truncate_text($post['content']);
?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo $post['image']; ?>" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8 d-flex flex-column">
                <div class="card-body">
                    <h5 class="card-title"><?php echo '<a class="stretched-link" href="./single.php?post_id=' . $post['id'] . '">' . $post['title'] . '</a>' ?></h5>
                    <p class="card-text"><?php echo $text ?></p>
                    <p class="card-text"><small class="text-muted"><?php echo 'Publié le ' . time_to_fr($post['date']) . ' par <a class="still_clickable" href="./author_posts.php?author_id=' . $post['author_id'] . '">' . get_author_name($post['author_id']) . '</a>' ?></small></p>
                </div>
                <div class="card-footer">
                    <p class="card-text"><small class="text-muted"><?php echo 'Catégorie : <a class="still_clickable" href="./category_posts.php?category_id=' . $post['category_id'] . '">' . get_category_name($post['category_id']) . '</a>' ?></small></p>
                </div>
            </div>
        </div>
    </div>
<?php
}
require './partials/footer.php';
