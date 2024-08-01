<?php
require 'config/database.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
}

$update_category_query = "UPDATE posts SET category_id = 8 WHERE category_id = $id";
$update_category_result = mysqli_multi_query($connection, $update_category_query);
if (!$update_category_result) {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
}

$delete_category_query = "DELETE FROM categories WHERE id = $id LIMIT 1";
$delete_category_result = mysqli_query($connection, $delete_category_query);

if ($delete_category_result) {
    $_SESSION['delete_category_success'] = "Category deleted successfully";
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    exit();
} else {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    exit();
}
