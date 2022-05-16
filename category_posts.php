<?php
require './functions.php';
if (isset($_GET['category_id']) && !empty($_GET['category_id']) && category_exists(htmlspecialchars($_GET['category_id']))) {
    $category_id = htmlspecialchars($_GET['category_id']);
    $category_posts = get_posts_by_category($category_id);
} else {
    header('Location: ./welcome.php');
    die();
}
require './partials/header.php';
include './partials/menu.php';
echo '<h2>' . get_category_name($category_id) . ' : </h2>';
foreach ($category_posts as $category_post) {
    $text = truncate_text($category_post['content']);
?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo $category_post['image']; ?>" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8 d-flex flex-column">
                <div class="card-body">
                    <h5 class="card-title"><?php echo '<a class="stretched-link" href="./single.php?post_id=' . $category_post['id'] . '">' . $category_post['title'] . '</a>' ?></h5>
                    <p class="card-text"><?php echo $text ?></p>
                    <p class="card-text"><small class="text-muted"><?php echo 'Publié le ' . time_to_fr($category_post['date']) . ' par <a class="still_clickable" href="./author_posts.php?author_id=' . $category_post['author_id'] . '">' . get_author_name($category_post['author_id']) . '</a>' ?></small></p>
                </div>
                <div class="card-footer">
                    <p class="card-text"><small class="text-muted"><?php echo 'Catégorie : <a class="still_clickable" href="./category_posts.php?category_id=' . $category_post['category_id'] . '">' . get_category_name($category_post['category_id']) . '</a>' ?></small></p>
                </div>
            </div>
        </div>
    </div>
<?php
}
require './partials/footer.php';
?>