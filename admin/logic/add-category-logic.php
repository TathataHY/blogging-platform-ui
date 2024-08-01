<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {
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

    // check if category already exists
    $category_check_query = "SELECT * FROM categories WHERE title = '$title'";
    $category_check_result = mysqli_query($connection, $category_check_query);
    if (mysqli_num_rows($category_check_result) > 0) {
        redirectWithError("Category already exists", $_POST);
    } else {
        $insert_category_query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $insert_category_result = mysqli_query($connection, $insert_category_query);
        if (mysqli_errno($connection)) {
            redirectWithError("Registration failed", $_POST);
        } else {
            $_SESSION['add_category_success'] = "Category added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }
} else {
    header('location: ' . ROOT_URL . 'admin/add-category.php');
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['add_category_data'] = $postData;
    $_SESSION['add_category_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'admin/add-category.php');
    exit();
}
