<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {

    $username_or_email = filter_var($_POST['username_or_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate user input
    if (empty($username_or_email)) {
        redirectWithError("Please enter your username or email", $_POST);
    } elseif (empty($password)) {
        redirectWithError("Please enter your password", $_POST);
    }

    $generic_error_message = "Invalid credentials, please try again.";

    // check if user exists
    $user_check_query = "SELECT * FROM users WHERE username = '$username_or_email' OR email = '$username_or_email'";
    $user_check_result = mysqli_query($connection, $user_check_query);
    if (mysqli_num_rows($user_check_result) > 0) {
        $user = mysqli_fetch_assoc($user_check_result);
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header('location: ' . ROOT_URL);
            exit();
        } else {
            redirectWithError($generic_error_message, $_POST);
        }
    } else {
        redirectWithError($generic_error_message, $_POST);
    }
} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['signin_data'] = $postData;
    $_SESSION['signin_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'signin.php');
    exit();
}
