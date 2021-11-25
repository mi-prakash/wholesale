<?php

class Product extends Dbh {

    protected static function getSellerProducts()
    {
        $user_id = $_SESSION['id'];
        $db = Dbh::connect();
        $query = $db->prepare("SELECT * FROM products WHERE publish_by = ? ORDER BY created_at ASC;");

        if (!$query->execute(array($user_id))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }

        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        return $products;
    }

    protected static function getAllSellerProducts($offset = null, $limit = 8)
    {
        $db = Dbh::connect();
        if ($offset == null) {
            $query = $db->prepare("SELECT products.*, users.name AS username FROM products JOIN users ON users.id = products.publish_by WHERE status = 'published' ORDER BY created_at DESC LIMIT $limit;");
        } else {
            $query = $db->prepare("SELECT products.*, users.name AS username FROM products JOIN users ON users.id = products.publish_by WHERE status = 'published' ORDER BY created_at DESC LIMIT $offset, $limit;");
        }

        if (!$query->execute()) {
            $query = null;
            header("location: ../index.php?error=queryfailed");
            exit;
        }

        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        return $products;
    }

    protected static function getSellerProductById ($id)
    {
        $user_id = $_SESSION['id'];
        $db = Dbh::connect();
        $query = $db->prepare("SELECT * FROM products WHERE publish_by = ? AND id = ?;");

        if (!$query->execute(array($user_id, $id))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }

        $product = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        return $product;
    }

    protected function setProduct($name, $retail_price, $wholesale_price, $publish_by, $status, $created_at, $updated_at)
    {
        $db = $this->connect();
        $query = $db->prepare("INSERT INTO products (name, retail_price, wholesale_price, publish_by, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?);");

        if (!$query->execute(array($name, $retail_price, $wholesale_price, $publish_by, $status, $created_at, $updated_at))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }
        $id = $db->lastInsertId();

        $query = null;
        
        return $id;
    }

    protected function editProduct($id, $name, $retail_price, $wholesale_price, $publish_by, $status, $updated_at)
    {
        $db = $this->connect();
        $query = $db->prepare("UPDATE products SET name = ?, retail_price = ?, wholesale_price = ?, publish_by = ?, status = ?, updated_at = ? WHERE id = ?;");

        if (!$query->execute(array($name, $retail_price, $wholesale_price, $publish_by, $status, $updated_at, $id))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }
        $query = null;
        
        return $id;
    }

    protected function setImage($image_path, $product_id, $column_name)
    {
        $db = $this->connect();
        $query = $db->prepare("UPDATE products SET $column_name = ? WHERE id = ?;");

        if (!$query->execute(array($image_path, $product_id))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }

        $query = null;

        return true;
    }

}