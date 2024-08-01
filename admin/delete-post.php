<?php
require 'config/database.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
    header('location: ' . ROOT_URL . 'admin');
    die();
}

$select_post_query = "SELECT * FROM posts WHERE id = $id";
$select_post_result = mysqli_query($connection, $select_post_query);
$post = mysqli_fetch_assoc($select_post_result);

if (mysqli_num_rows($select_post_result) == 0) {
    header('location: ' . ROOT_URL . 'admin');
    die();
} elseif (mysqli_num_rows($select_post_result) ==  1) {
    $thumbnail_name = $post['thumbnail'];
    $thumbnail_path = ROOT_PATH . 'images/' . $thumbnail_name;

    if ($thumbnail_path) {
        unlink($thumbnail_path);
    }

    $delete_post_query = "DELETE FROM posts WHERE id = $id";
    $delete_post_result = mysqli_query($connection, $delete_post_query);

    if ($delete_post_result) {
        $_SESSION['delete_post_success'] = "Post deleted successfully";
        header('location: ' . ROOT_URL . 'admin');
        exit();
    } else {
        header('location: ' . ROOT_URL . 'admin');
        exit();
    }
}
