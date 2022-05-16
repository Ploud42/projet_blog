<?php

require './functions.php';
if (isset($_POST['pseudo'], $_POST['comment'], $_POST['post_id']) && !empty($_POST['pseudo']) && !empty($_POST['comment']) && !empty($_POST['post_id'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $comment = htmlspecialchars($_POST['comment']);
    $post_id = htmlspecialchars($_POST['post_id']);
    create_comment($pseudo, $comment, $post_id);
}
