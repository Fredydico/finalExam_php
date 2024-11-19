<?php
include(__DIR__ . '/../Config/init.php');

$productController = new ProductController();

$categoryId = $_GET['id'] ?? null; 

if ($categoryId) {
    $category = $productController->getCategoryById($categoryId);
} else {
    echo "ID kategori tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    
    if ($productController->updateCategory($categoryId, $category_name)) {
        header('Location: ../index.php');
        exit;
    } else {
        echo "Gagal mengupdate kategori.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Category</h2>
    
    <form method="POST">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>
</body>
</html>
