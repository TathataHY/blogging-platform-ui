<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require ROOT_PATH . 'config/database.php';

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // validate user input
    if (empty($firstname)) {
        redirectWithError("Please enter your first name", $_POST);
    } elseif (empty($lastname)) {
        redirectWithError("Please enter your last name", $_POST);
    } elseif (empty($username)) {
        redirectWithError("Please enter a username", $_POST);
    } elseif (empty($email)) {
        redirectWithError("Please enter an email", $_POST);
    } elseif (empty($password)) {
        redirectWithError("Please enter a password", $_POST);
    } elseif (empty($confirm_password)) {
        redirectWithError("Please confirm your password", $_POST);
    } elseif ($role === '' || !in_array($role, ['0', '1'])) {
        redirectWithError("Please select a valid role", $_POST);
    } elseif (empty($avatar['name'])) {
        redirectWithError("Please upload an avatar", $_POST);
    }

    // validate user input
    if (strlen($username) < 5) {
        redirectWithError("Username must be at least 5 characters", $_POST);
    } elseif (strlen($password) < 8) {
        redirectWithError("Password must be at least 8 characters", $_POST);
    } elseif ($password !== $confirm_password) {
        redirectWithError("Passwords do not match", $_POST);
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $firstname)) {
        redirectWithError("First name must only contain letters and spaces", $_POST);
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $lastname)) {
        redirectWithError("Last name must only contain letters and spaces", $_POST);
    }

    // check avatar image
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $ext = explode('.', $avatar['name']);
    $ext = end($ext);
    if (!in_array($ext, $allowed_ext)) {
        redirectWithError("Avatar must be a jpg, jpeg, or png image", $_POST);
    } elseif ($avatar['size'] > 1000000) {
        redirectWithError("Avatar must be less than 1MB", $_POST);
    }

    // check if username or email already exists   
    $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $user_check_result = mysqli_query($connection, $user_check_query);

    if (mysqli_num_rows($user_check_result) > 0) {
        redirectWithError("Username or email already exists", $_POST);
    } else {
        // upload avatar
        $avatar_name = time() . $avatar['name'];
        $avatar_destination_path = ROOT_PATH . 'images/' . $avatar_name;
        move_uploaded_file($avatar['tmp_name'], $avatar_destination_path);

        // hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // insert user into database
        $insert_user_query = "INSERT INTO users (username, email, password, firstname, lastname, avatar, is_admin) VALUES ('$username', '$email', '$hashed_password', '$firstname', '$lastname', '$avatar_name', '$role')";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if (!$insert_user_result) {
            redirectWithError("Registration failed", $_POST);
        } else {
            $_SESSION['add_user_success'] = "Registration successful";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
} else {
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}

function redirectWithError($errorMessage, $postData = [])
{
    $_SESSION['add_user_data'] = $postData;
    $_SESSION['add_user_error'] = $errorMessage;
    header('Location: ' . ROOT_URL . 'admin/add-user.php');
    exit();
}
