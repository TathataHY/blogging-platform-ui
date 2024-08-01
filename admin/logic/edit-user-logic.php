<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);

    // validate user input
    if (empty($firstname)) {
        redirectWithError("Please enter your first name", $_POST);
    } elseif (empty($lastname)) {
        redirectWithError("Please enter your last name", $_POST);
    } elseif ($role === '' || !in_array($role, ['0', '1'])) {
        redirectWithError("Please select a valid role", $_POST);
    }

    // validate user input
    if (!preg_match("/^[a-zA-Z\s]*$/", $firstname)) {
        redirectWithError("First name must only contain letters and spaces", $_POST);
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $lastname)) {
        redirectWithError("Last name must only contain letters and spaces", $_POST);
    }

    // update user
    $update_user_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = '$role' WHERE id = '$id' LIMIT 1";
    $update_user_result = mysqli_query($connection, $update_user_query);
    if ($update_user_result) {
        $_SESSION['edit_user_success'] = "User updated successfully";
        header('Location: ' . ROOT_URL . 'admin/manage-users.php');
        exit();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/edit-user.php?id=' . $_POST['id']);
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['edit_user_data'] = $postData;
    $_SESSION['edit_user_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'admin/edit-user.php?id=' . $_POST['id']);
    exit();
}
