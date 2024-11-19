<?php
require_once(__DIR__ . '/../Config/init.php');
require_once(__DIR__ . '/../Controller/ProductController.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productController = new ProductController();
    
    $productController->destroy($id);
    
    header('Location: ../index.php');
    exit;
} else {
    echo "No product ID provided!";
}
?>