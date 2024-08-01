<?php
require 'config/database.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}

$select_user_query = "SELECT * FROM users WHERE id = $id";
$select_user_result = mysqli_query($connection, $select_user_query);
$user = mysqli_fetch_assoc($select_user_result);

if (mysqli_num_rows($select_user_result) == 0) {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
} elseif (mysqli_num_rows($select_user_result) ==  1) {
    $avatar_name = $user['avatar'];
    $avatar_path = ROOT_PATH . 'images/' . $avatar_name;

    if ($avatar_path) {
        unlink($avatar_path);
    }

    $select_thumbnails_query = "SELECT * FROM posts WHERE author_id = $id";
    $select_thumbnails_result = mysqli_query($connection, $select_thumbnails_query);
    if (mysqli_num_rows($select_thumbnails_result) > 0) {
        while ($thumbnail = mysqli_fetch_assoc($select_thumbnails_result)) {
            $thumbnail_name = $thumbnail['thumbnail'];
            $thumbnail_path = ROOT_PATH . 'images/' . $thumbnail_name;
            if ($thumbnail_path) {
                unlink($thumbnail_path);
            }
        }
    }

    $delete_user_query = "DELETE FROM users WHERE id = $id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);

    if ($delete_user_result) {
        $_SESSION['delete_user_success'] = "User deleted successfully";
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        exit();
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        exit();
    }
}
