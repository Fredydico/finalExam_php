<?php
require(__DIR__ . '/../Config/init.php');

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index()
    {
        return $this->productModel->getAllProducts();
    }

    public function create($data)
    {
        return $this->productModel->createProduct($data);
    }

    public function show($id)
    {
        return $this->productModel->getProductById($id);
    }

    public function update($id, $data)
    {
        return $this->productModel->updateProduct($id, $data);
    }

    public function destroy($id)
    {
        $this->productModel->deleteProduct($id);
    }

    public function restore()
    {
        $this->productModel->restoreProduct();
    }

    public function getProductById($id)
    {
        return $this->productModel->getProductById($id);
    }

    public function addCategory($data) {
        $db = Database::getInstance(); 
        $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':category_name', $data['category_name'], PDO::PARAM_STR);
        
        return $stmt->execute(); 
    }

    public function getCategories() {
        $db = Database::getInstance(); 
        $sql = "SELECT id, category_name FROM categories WHERE isDeleted = 0";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $category_name)
    {
        $db = Database::getInstance();
        $sql = "UPDATE categories SET category_name = :category_name WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getCategoryById($id)
    {
        $db = Database::getInstance();
        $sql = "SELECT id, category_name FROM categories WHERE id = :id AND isDeleted = 0";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteCategory($id)
    {
        $db = Database::getInstance();
        $sql = "UPDATE categories SET isDeleted = 1 WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function restoreCategories()
    {
        $db = Database::getInstance();
        $sql = "UPDATE categories SET isDeleted = 0 WHERE isDeleted = 1";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
?>
