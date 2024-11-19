<?php
require_once(__DIR__ . '/Config/init.php');

$productController = new ProductController();
$products = $productController->index();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['restore_products'])) {
        echo "Restore Products button clicked!";
        $productController->restore();
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['restore_categories'])) {
        echo "Restore Categories button clicked!";
        $productController->restoreCategories();
        header('Location: index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <br><br>
        <h3>Categories</h3>
        <a href="View/add_category.php" class="btn btn-success mb-3">Add Category</a>
        <ul class="list-group">
            <?php
            $categories = $productController->getCategories();
            foreach ($categories as $category) {
                echo "<li class='list-group-item d-flex justify-content-between'>
                        {$category['category_name']}
                        <div class='actions'>
                            <a href='View/edit_category.php?id={$category['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='View/delete_category.php?id={$category['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</a>
                        </div>
                    </li>";
            }
            ?>
        </ul>
        <form method="POST" class="mt-3">
            <button type="submit" name="restore_categories" class="btn btn-secondary">Restore Categories</button>
        </form>

            <br><br>
        <h3>Product</h3>
        <a href="View/create.php" class="btn btn-success mb-3">Add New Product</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo ($product['id']); ?></td>
                            <td><?php echo ($product['product_name']); ?></td>
                            <td><?php echo ($product['price']); ?></td>
                            <td><?php echo ($product['stock']); ?></td>
                            <td><?php echo ($product['category_name']); ?></td>
                            <td class="actions">
                                <a href="View/detail.php?id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="View/update.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="View/delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No products available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <form method="POST" class="mt-3">
            <button type="submit" name="restore_products" class="btn btn-secondary">Restore Products</button>
        </form>
    </div>
</body>

</html>
