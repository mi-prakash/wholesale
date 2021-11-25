<?php

class Order extends Dbh {

    protected static function getAllOrders()
    {
        $user_id = $_SESSION['id'];
        $db = Dbh::connect();
        $query = $db->prepare("SELECT orders.*, users.name AS ordered_by, products.name AS product_name, products.retail_price, products.wholesale_price, products.image
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

}