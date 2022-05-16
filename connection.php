<?php
function dbconnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=ex_blog;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
