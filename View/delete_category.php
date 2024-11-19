<?php
include(__DIR__ . '/../Config/init.php');

$categoryController = new ProductController();
$categoryId = $_GET['id'];

if ($categoryController->deleteCategory($categoryId)) {
    header('Location: /index.php'); // Redirect after delete
    exit;
} else {
    echo 'Failed to delete category';
}
