<?php
require_once(__DIR__ . '/../Config/init.php');

$productController = new ProductController();
$errors = [];
$category_name = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate category name
    if (empty($_POST['category_name'])) {
        $errors['category_name'] = "Category name is required";
    } else {
        $category_name = $_POST['category_name'];
    }

    // If there are no validation errors, add category
    if (empty($errors)) {
        $data = [
            'category_name' => $category_name,
        ];

        if ($productController->addCategory($data)) {
            echo "<script>alert('Category added successfully!'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Failed to add category!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Add Category</h2>

        <!-- Form to add category -->
        <form method="POST" action="add_category.php">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo htmlspecialchars($category_name); ?>">
                <?php
                if (isset($errors['category_name'])) {
                    echo "<small class='text-danger'>{$errors['category_name']}</small>";
                }
                ?>
            </div>
                <br>
            <button type="submit" class="btn btn-primary mt-3">Add Category</button>
        </form>
    </div>
</body>
</html>
