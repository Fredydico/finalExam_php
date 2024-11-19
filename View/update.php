<?php
include(__DIR__ . '/../Config/init.php');

$id = $_GET['id'] ?? null;

if ($id === null) {
    die("Product ID is missing.");
}

$productController = new ProductController();
$errors = [];

// Mengambil data produk berdasarkan ID
$product = $productController->show($id);

if (!$product) {
    die("Product not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["product_name"])) {
        $errors['product_name'] = "Product Name is required";
    } else {
        $product_name = $_POST["product_name"];
    }

    if (empty($_POST["price"])) {
        $errors['price'] = "Price is required";
    } else if (!is_numeric($_POST["price"])) {
        $errors['price'] = "Price must be a number";
    } else if (floatval($_POST["price"]) <= 0) {
        $errors['price'] = "Price should be greater than zero";
    } else {
        $price = $_POST["price"];
    }

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

    // Validate category_id
    $category_id = $_POST['category_id'] ?? null;
    if (empty($category_id)) {
        $errors['category_id'] = "Category is required";
    }

    // If there are no errors, proceed with updating the product
    if (empty($errors)) {
        $data = [
            'product_name' => $product_name,
            'category_id' => $category_id,
            'price' => $price,
            'stock' => $stock
        ];

        // Call the ProductController's update method
        if ($productController->update($id, $data)) {
            header("Location: ../index.php"); // Redirect after successful update
        } else {
            echo "Error updating the product."; // Display error message if failed
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: auto;
        }

        label {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Product</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            <small class="text-danger"><?php echo $errors['product_name'] ?? ''; ?></small>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            <small class="text-danger"><?php echo $errors['price'] ?? ''; ?></small>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
            <small class="text-danger"><?php echo $errors['stock'] ?? ''; ?></small>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" name="category_id" id="category_id" required>
                <?php
                $categories = $productController->getCategories();
                foreach ($categories as $category) {
                    echo "<option value='{$category['id']}'" . ($category['id'] == $product['category_id'] ? ' selected' : '') . ">{$category['category_name']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
</body>
</html>