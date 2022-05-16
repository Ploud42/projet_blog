<?php
// A FAIRE !! Requetes SQL en prepare()
require './connection.php';

session_start();

function add_user($pseudo, $pwd, $mail)
{
    $pwd = password_hash($pwd, PASSWORD_BCRYPT);
    $db = dbconnect();
    /* $db->exec("INSERT INTO users (id, pseudo, password, email) VALUES (NULL,'$pseudo','$pwd','$mail')"); */ // erreur causée par les ' ' autours de users
    $query = $db->prepare("INSERT INTO users VALUES (null, :pseudo, :pwd, :mail)");
    $query->bindParam(':pseudo', $pseudo);
    $query->bindParam(':pwd', $pwd);
    $query->bindParam(':mail', $mail);
    $query->execute();
}

function user_exists($pseudo, $pwd)
{
    $db = dbconnect();
    $statement = $db->query("SELECT * FROM users WHERE pseudo = '$pseudo'");
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    //$user_confirmed = $db->query("SELECT * FROM users WHERE pseudo = '$pseudo' AND password = '$pwd'");
    if (empty($user))
        return 0;
    else if (password_verify($pwd, $user['password']))
        return $user['id'];
    else
        return -1;
}

function time_to_fr($time)
{
    $time_fr = strtotime($time);
    $time_fr = date("d-m-Y à G:i", $time_fr);
    return $time_fr;
}
function get_categories()
{
    $db = dbconnect();
    $statement = $db->query("SELECT DISTINCT * FROM category");
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_author_name($author_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT pseudo FROM users WHERE id = '$author_id'");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['pseudo'];
}

function get_category_name($cat_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT name FROM category WHERE id = '$cat_id'");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['name'];
}

function get_posts_by_author($author_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT * FROM posts WHERE author_id=" . $author_id . " ORDER BY date DESC");
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

function get_posts_by_category($category_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT * FROM posts WHERE category_id=" . $category_id . " ORDER BY date DESC");
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

function get_x_posts($x)
{
    $db = dbconnect();
    if (isset($x) && $x > 0 && $x < 10)
        $statement = $db->query("SELECT * FROM posts ORDER BY date DESC LIMIT $x");
    else
        $statement = $db->query("SELECT * FROM posts ORDER BY date DESC LIMIT 5");
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

function get_post($post_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT * FROM posts WHERE id = '$post_id'");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function create_post($title, $content, $img, $id, $category_id)
{
    $date = date("Y-m-d G:i:s");
    $db = dbconnect();
    $db->exec("INSERT INTO posts VALUES (NULL,'$title','$content','$date', '$img', '$id', '$category_id')");
    $id = $db->lastInsertId();
    return ($id);
}

function truncate_text($text)
{
    return (substr($text, 0, 400) . '...');
}

function category_exists($category_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT * FROM category WHERE id = '$category_id'");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (empty($result))
        return 0;
    else
        return 1;
}

function post_exists($post_id)
{
    $db = dbconnect();
    $statement = $db->query("SELECT * FROM posts WHERE id = '$post_id'");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (empty($result))
        return 0;
    else
        return 1;
}

function post_is_from_this_user($user_id, $post_id)
{
    $db = dbconnect();
    $query = $db->prepare("SELECT * FROM posts WHERE id=:post_id AND author_id=:user_id");
    $query->bindParam(':post_id', $post_id);
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($result))
        return 0;
    else
        return 1;
}

function edit_post($id, $title, $image, $content, $category_id)
{
    $db = dbconnect();
    $query = $db->prepare("UPDATE posts SET title=:title, image=:image, content=:content, category_id=:category WHERE id=:id");
    $query->bindParam(':id', $id);
    $query->bindParam(':title', $title);
    $query->bindParam(':image', $image);
    $query->bindParam(':content', $content);
    $query->bindParam(':category', $category_id);
    $query->execute();
}

function delete_post($id)
{
    $db = dbconnect();
    $query_name = $db->prepare("SELECT image FROM posts WHERE id=:id");
    $query_name->bindParam(':id', $id);
    $query_name->execute();
    $img_name = $query_name->fetch(PDO::FETCH_ASSOC);
    unlink($img_name['image']);
    $comm_query = $db->prepare("DELETE FROM commentary WHERE post_id=:id");
    $comm_query->bindParam(':id', $id);
    $comm_query->execute();
    $query = $db->prepare("DELETE FROM posts WHERE id=:id");
    $query->bindParam(':id', $id);
    $query->execute();
}

function create_comment($pseudo, $comment, $post_id)
{
    $date = date("Y-m-d G:i:s");
    $db = dbconnect();
    $query = $db->prepare("INSERT INTO commentary VALUES (null, :pseudo, :comment, :post_id, :date)");
    $query->bindParam(':pseudo', $pseudo);
    $query->bindParam(':comment', $comment);
    $query->bindParam(':post_id', $post_id);
    $query->bindParam(':date', $date);
    $query->execute();
}

function get_comments_per_post($post_id)
{
    $db = dbconnect();
    $query = $db->prepare("SELECT * FROM commentary WHERE post_id=:post_id ORDER BY time ASC");
    $query->bindParam(':post_id', $post_id);
    $query->execute();
    $result = $query->fetchall(PDO::FETCH_ASSOC);
    return $result;
}
