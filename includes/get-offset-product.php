<?php

session_start();
$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

if (isset($_GET)) {
    $offset = $_GET['offset'];

    // Instantiate Product class
    include_once $base_url."classes/dbh.class.php";
    include_once $base_url."classes/product.class.php";
    include_once $base_url."classes/product-contr.class.php";

    $products = ProductContr::getAllProducts($offset);
    $result = json_encode($products);
    echo $result;
}