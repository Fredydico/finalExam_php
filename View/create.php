<?php
require(__DIR__ . '/../Config/init.php');

$productController = new ProductController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate product_name
    if (empty($_POST["product_name"])) {
        $errors['product_name'] = "Product Name is required";
    } else {
        $product_name = $_POST["product_name"];
    }

    // Validate price
    if (empty($_POST["price"])) {
        $errors['price'] = "Price is required";
    } else if (!is_numeric($_POST["price"])) {
        $errors['price'] = "Price must be a number";
    } else if (floatval($_POST["price"]) <= 0) {
        $errors['price'] = "Price should be greater than zero";
    } else {
        $price = $_POST["price"];
    }

    // Validate stock (formerly stock)
    if (!isset($_POST["stock"]) || empty($_POST["stock"])) {
        $errors['stock'] = "Stock is required";
    } else if (!is_numeric($_POST["stock"])) {
        $errors['stock'] = "Stock must be a valid number";
    } else if ((int)$_POST["stock"] < 0) {
        $errors['stock'] = "Stock cannot be negative";
    } else if ($_POST["stock"] != (string)(int)$_POST["stock"]) {
        $errors['stock'] = "Stock must be an integer";
    } else {
        $stock = $_POST["stock"];
    }

    $category_id = $_POST["category_id"];

    if (empty($errors)) {
        $data = [
            'product_name' => $product_name,
            'category_id' => $category_id,
            'price' => $price,
            'stock' => $stock
        ];

        if ($productController->create($data)) {
            echo "<script>alert('Product added successfully!')</script>";
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script>alert('Failed to add product!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Product</h2>
    <form action="create.php" method="POST">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" id="product_name" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" required>
        </div>
        <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <?php
                $categories = $productController->getCategories();
                foreach ($categories as $category) {
                    echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                }
            ?>
        </select>
    </div>
    <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
