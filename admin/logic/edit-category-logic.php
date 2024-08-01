<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate user input
    if (empty($title)) {
        redirectWithError("Please enter a title", $_POST);
    } elseif (empty($description)) {
        redirectWithError("Please enter a description", $_POST);
    }

    // validate user input
    if (strlen($title) < 1) {
        redirectWithError("Title must be at least 5 characters", $_POST);
    } elseif (strlen($description) < 10) {
        redirectWithError("Description must be at least 10 characters", $_POST);
    }

    // update category
    $update_category_query = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id LIMIT 1";
    $update_category_result = mysqli_query($connection, $update_category_query);
    if ($update_category_result) {
        $_SESSION['edit_category_success'] = "Category updated successfully";
        header('Location: ' . ROOT_URL . 'admin/manage-categories.php');
        exit();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $_POST['id']);
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['edit_category_data'] = $postData;
    $_SESSION['edit_category_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $_POST['id']);
    exit();
}
