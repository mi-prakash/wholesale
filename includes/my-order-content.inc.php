<?php

$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

// Instantiate Product class
include_once $base_url."classes/dbh.class.php";
include_once $base_url."classes/my-order.class.php";
include_once $base_url."classes/my-order-contr.class.php";

class MyOrderContent {
    public static function get_my_orders() {
        return MyOrderContr::getMyOrders();
    }
}
