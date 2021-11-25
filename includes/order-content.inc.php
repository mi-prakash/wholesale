<?php

$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

// Instantiate Product class
include_once $base_url."classes/dbh.class.php";
include_once $base_url."classes/order.class.php";
include_once $base_url."classes/order-contr.class.php";

class OrderContent {
    public static function get_orders() {
        return OrderContr::getOrders();
    }
}
