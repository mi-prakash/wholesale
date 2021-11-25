<?php

class Order extends Dbh {

    protected static function getAllOrders()
    {
        $user_id = $_SESSION['id'];
        $db = Dbh::connect();
        $query = $db->prepare("SELECT orders.*, users.name AS purchased_by, products.name AS product_name, products.retail_price, products.wholesell_price, products.image
                                FROM orders
                                JOIN users ON users.id = orders.user_id
                                JOIN products ON products.id = orders.product_id
                                WHERE products.publish_by = ? 
                                ORDER BY created_at DESC;");

        if (!$query->execute(array($user_id))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }

        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        return $products;
    }

    protected function setOrder($user_id, $product_id, $created_at, $updated_at)
    {
        $db = $this->connect();
        /* $query = $db->prepare("INSERT INTO products (name, retail_price, wholesell_price, publish_by, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?);");

        if (!$query->execute(array($name, $retail_price, $wholesell_price, $publish_by, $status, $created_at, $updated_at))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }
        $id = $db->lastInsertId();

        $query = null;
        
        return $id; */
    }

}