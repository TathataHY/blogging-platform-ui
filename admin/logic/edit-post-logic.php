<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    $previous_thumbnail = filter_var($_POST['previous_thumbnail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $is_featured = $is_featured == 1 ? 1 : 0;

    // validate user input
    if (empty($title)) {
        redirectWithError("Please enter a title", $_POST);
    } elseif (empty($body)) {
        redirectWithError("Please enter a body", $_POST);
    } elseif (empty($category_id)) {
        redirectWithError("Please select a category", $_POST);
    }

    // validate user input
    if (strlen($title) < 1) {
        redirectWithError("Title must be at least 5 characters", $_POST);
    } elseif (strlen($body) < 10) {
        redirectWithError("Body must be at least 10 characters", $_POST);
    } elseif (strlen($title) > 255) {
        redirectWithError("Title must be less than 255 characters", $_POST);
    } elseif (strlen($body) > 10000) {
        redirectWithError("Body must be less than 10000 characters", $_POST);
    }

    if ($thumbnail['name']) {
        // check avatar image
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        $ext = explode('.', $thumbnail['name']);
        $ext = end($ext);
        if (!in_array($ext, $allowed_ext)) {
            redirectWithError("Thumbnail must be a jpg, jpeg, or png image", $_POST);
        } elseif ($thumbnail['size'] > 2000000) {
            redirectWithError("Thumbnail must be less than 2MB", $_POST);
        }

        $previous_thumbnail_path = ROOT_PATH . 'images/' . $previous_thumbnail;
        if ($previous_thumbnail_path) {
            unlink($previous_thumbnail_path);
        }

        $thumbnail_name = uniqid() . $thumbnail['name'];
        $thumbnail_destination_path = ROOT_PATH . 'images/' . $thumbnail_name;
        move_uploaded_file($thumbnail['tmp_name'], $thumbnail_destination_path);
    } else {
        $thumbnail_name = $previous_thumbnail;
    }

    if ($is_featured == 1) {
        $featured_query = "UPDATE posts SET is_featured = 0";
        $featured_result = mysqli_query($connection, $featured_query);
        if (!$featured_result) {
            redirectWithError("Failed to update featured posts", $_POST);
        }
    }

    // update post
    $update_post_query = "UPDATE posts SET title = '$title', body = '$body', category_id = $category_id, thumbnail = '$thumbnail_name', is_featured = $is_featured WHERE id = $id LIMIT 1";
    $update_post_result = mysqli_query($connection, $update_post_query);
    if (!$update_post_result) {
        redirectWithError("Failed to update post", $_POST);
    } else {
        $_SESSION['edit_post_success'] = "Post updated successfully";
        header('location: ' . ROOT_URL . 'admin');
        exit();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $_POST['id']);
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['edit_post_data'] = $postData;
    $_SESSION['edit_post_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $_POST['id']);
    exit();
}
