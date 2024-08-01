<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    $author_id = $_SESSION['user_id'];

    $is_featured = $is_featured == 1 ? 1 : 0;

    // validate user input
    if (empty($title)) {
        redirectWithError("Please enter a title", $_POST);
    } elseif (empty($body)) {
        redirectWithError("Please enter a body", $_POST);
    } elseif (empty($category_id)) {
        redirectWithError("Please select a category", $_POST);
    } elseif (empty($thumbnail['name'])) {
        redirectWithError("Please upload a thumbnail", $_POST);
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

    // check avatar image
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $ext = explode('.', $thumbnail['name']);
    $ext = end($ext);
    if (!in_array($ext, $allowed_ext)) {
        redirectWithError("Thumbnail must be a jpg, jpeg, or png image", $_POST);
    } elseif ($thumbnail['size'] > 2000000) {
        redirectWithError("Thumbnail must be less than 2MB", $_POST);
    }

    if ($is_featured == 1) {
        $featured_query = "UPDATE posts SET is_featured = 0";
        $featured_result = mysqli_query($connection, $featured_query);
        if (!$featured_result) {
            redirectWithError("Failed to update featured posts", $_POST);
        }
    }

    // upload thumbnail
    $thumbnail_name = uniqid() . $thumbnail['name'];
    $thumbnail_destination_path = ROOT_PATH . 'images/' . $thumbnail_name;
    move_uploaded_file($thumbnail['tmp_name'], $thumbnail_destination_path);

    $insert_post_query = "INSERT INTO posts (title, body, category_id, thumbnail, author_id, is_featured) VALUES ('$title', '$body', '$category_id', '$thumbnail_name', '$author_id', '$is_featured')";
    $insert_post_result = mysqli_query($connection, $insert_post_query);
    if (mysqli_errno($connection)) {
        redirectWithError("Registration failed", $_POST);
    } else {
        $_SESSION['add_post_success'] = "Post added successfully";
        header('location: ' . ROOT_URL . 'admin');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/add-post.php');
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['add_post_data'] = $postData;
    $_SESSION['add_post_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'admin/add-post.php');
    exit();
}
