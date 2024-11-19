<?php
require(__DIR__ . '/../Config/init.php');

class Product extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('products');
    }

    public function getAllProducts()
    {
        $query = "SELECT p.id, p.product_name, p.price, p.stock, c.category_name 
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.isDeleted = 0";  
        
        $stmt = Database::getInstance()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $query = "SELECT p.id, p.product_name, p.price, p.stock, c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id";
        
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function createProduct($data)
    {
        return $this->db->insertData($this->tableName, $data);
    }

    public function updateProduct($id, $data)
    {
        return $this->db->updateData($this->tableName, $id, $data);
    }

    public function deleteProduct($id)
    {
        $db = Database::getInstance();
        $sql = "UPDATE products SET isDeleted = 1 WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute(); 
    }

    public function restoreProduct()
    {
        $db = Database::getInstance();
        $sql = "UPDATE products SET isDeleted = 0 WHERE isDeleted = 1";
        $stmt = $db->prepare($sql);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
]