<?php

class MyOrder extends Dbh {

    protected static function getAllMyOrders()
    {
        $user_id = $_SESSION['id'];
        $db = Dbh::connect();
        $query = $db->prepare("SELECT orders.*, users.name AS posted_by, products.name AS product_name, products.retail_price, products.wholesale_price, products.image
                                FROM orders 
                                JOIN products ON products.id = orders.product_id
                                JOIN users ON users.id = products.publish_by 
                                WHERE orders.user_id = ? 
                                ORDER BY orders.created_at DESC;");

        if (!$query->execute(array($user_id))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }

        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        return $products;
    }

    protected function checkOrderIsValid($user_id, $product_id) {
        $db = $this->connect();
        $query = $db->prepare("SELECT * FROM orders WHERE user_id = ? AND product_id = ?;");

        if (!$query->execute(array($user_id, $product_id))) {
            $query = null;
            header("location: ../index.php?error=queryfailed");
            exit;
        }

        $check_order = false;
        if ($query->rowCount() < 5) {
            $check_order = true;
        }
        $query = null;

        return $check_order;
    }

    protected function setMyOrder($user_id, $product_id, $created_at, $updated_at)
    {
        $db = $this->connect();
        $query = $db->prepare("INSERT INTO orders (user_id, product_id, created_at, updated_at) VALUES (?, ?, ?, ?);");

        if (!$query->execute(array($user_id, $product_id, $created_at, $updated_at))) {
            $query = null;
            header("location: ../product-list.php?error=queryfailed");
            exit;
        }
        $query = null;
        
        return true;
    }

}