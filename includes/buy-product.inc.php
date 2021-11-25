<?php

session_start();
$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

if (isset($_POST)) {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // POST data is valid.
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['id'];
        $user_type = $_SESSION['type'];

        // Instantiate classes
        include_once $base_url."classes/dbh.class.php";
        include_once $base_url."classes/my-order.class.php";
        include_once $base_url."classes/my-order-contr.class.php";
        include_once $base_url."includes/product-content.inc.php";

        // Get product details
        $product = ProductContent::get_product_detail_by_id($product_id);
        $product = $product[0];

        // If buyer is the seller return error
        if ($product["publish_by"] == $user_id) {
            $response = array(
                "status" => "error",
                "message" => "Can not order your own Product!"
            );
            $response = json_encode($response);
            echo $response;
            exit;
        }

        // Check if product is valid for order
        $created_at = date("Y-m-d H:i:s");
        $updated_at = $created_at;
        $my_order = new MyOrderContr($user_id, $product_id, $created_at, $updated_at);
        $check_order = $my_order->checkOrderValid();

        if (!$check_order) {
            $response = array(
                "status" => "error",
                "message" => "You have already ordered this item 5 times!"
            );
            $response = json_encode($response);
            echo $response;
            exit;
        }

        // Check if order is from Seller or Customer
        if ($user_type == "customer") {
            // Process adding order
            $add_order = $my_order->addMyOrder();

            if ($add_order) {
                $response = array(
                    "status" => "success",
                    "message" => "Product successfully ordered"
                );
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Failed to order the product!"
                );
            }
            $response = json_encode($response);
            echo $response;
            exit;
        } else {
            // Process adding order
            $add_order = $my_order->addMyOrder();
            
            if ($add_order) {
                // Add ordered product to seller product list
                $set_seller_product = ProductContent::set_product_for_seller($product, $user_id);

                if ($set_seller_product) {
                    $response = array(
                        "status" => "success",
                        "message" => "Product successfully ordered"
                    );
                } else {
                    $response = array(
                        "status" => "error",
                        "message" => "Product successfully ordered but failed saved on your Product list!"
                    );
                }
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Failed to order the product!"
                );
            }
            $response = json_encode($response);
            echo $response;
            exit;
        }

    } else {
        $response = array(
            "status" => "csrf_error",
            "message" => "CSRF token mismatch"
        );
    }

    $response = json_encode($response);
    echo $response;
}