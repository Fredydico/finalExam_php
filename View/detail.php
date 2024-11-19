<?php
include(__DIR__ . '/../Config/init.php');

$id = $_GET['id'];
$productController = new ProductController();
$product = $productController->getProductById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Product Details</h2>
    <br>
    <p><strong>Name:</strong> <?php echo $product['product_name']; ?></p>
    <p><strong>Price:</strong> <?php echo $product['price']; ?></p>
    <p><strong>Stock:</strong> <?php echo $product['stock']; ?></p>
    <p><strong>Category:</strong><?php echo $product['category_name']; ?></>
    <p>
        <a href="../index.php" class="btn btn-primary">Home</a>
    </p>
</div>
</body>
</html>
