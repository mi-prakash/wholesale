<?php

session_start();
$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

if (isset($_POST)) {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // POST data is valid.
        $name = $_POST['name'];
        $retail_price = $_POST['retail_price'];
        $wholesale_price = $_POST['wholesale_price'];
        $status = $_POST['status'];
        $is_img1_added = $_POST['is_img1_added'];
        $is_img2_added = $_POST['is_img2_added'];
        $publish_by  = $_SESSION['id'];
        $created_at = date("Y-m-d H:i:s");
        $updated_at = $created_at;

        // Instantiate ProductContr class
        include_once $base_url."classes/dbh.class.php";
        include_once $base_url."classes/product.class.php";
        include_once $base_url."classes/product-contr.class.php";

        $product = new ProductContr($name, $retail_price, $wholesale_price, $publish_by, $status, $created_at, $updated_at);

        // Running error handlers and user product
        $add_product = $product->addProduct();

        if (isset($add_product["status"]) && $add_product["status"] == "error") {
            $response = json_encode($add_product);
            echo $response;
            exit;
        }
        $product_id = $add_product;
        $img1_failed = false;
        $img2_failed = false;
        
        if($product_id > 0) {
            if ($is_img1_added != 0) {
                if ($_FILES['image']['name']) {
                    // echo $_FILES['image']['name']; exit;
                    $img_name = $_FILES['image']['name']; // getting user uploaded name
                    $img_type = $_FILES['image']['type']; // getting user uploaded img type
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
                    $save_path = $base_url."assets/images/products/"; // Folder where you wanna move the file.
                    $new_img1_name = "ID_".$product_id."_IMG1_".uniqid().".".$ext; // You are renaming the file here
                    $move_img1 = move_uploaded_file($_FILES['image']['tmp_name'], $save_path . $new_img1_name); // Move the uploaded file to the desired folder
                    if(!$move_img1) {
                        $img1_failed = true;
                    } else {
                        // update image to db
                        $image_path = "assets/images/products/" . $new_img1_name;
                        $product->addImage($image_path, $product_id, 'image');
                    }
                }
            }
            
            if ($is_img2_added != 0) {
                if ($_FILES['image_2']['name']) {
                    // echo $_FILES['image_2']['name']; exit;
                    $img_name = $_FILES['image_2']['name']; // getting user uploaded name
                    $img_type = $_FILES['image_2']['type']; // getting user uploaded img type
                    $tmp_name = $_FILES['image_2']['tmp_name'];
                    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
                    $save_path = $base_url."assets/images/products/"; // Folder where you wanna move the file.
                    $new_img2_name = "ID_".$product_id."_IMG2_".uniqid().".".$ext; // You are renaming the file here
                    $move_img2 = move_uploaded_file($_FILES['image_2']['tmp_name'], $save_path . $new_img2_name); // Move the uploaded file to the desired folder
                    if(!$move_img2) {
                        $img2_failed = true;
                    } else {
                        // update image to db
                        $image_path = "assets/images/products/" . $new_img2_name;
                        $product->addImage($image_path, $product_id, 'image_2');
                    }
                }
            }
        }

        $product_detail = ProductContr::getProductById($product_id);

        if($img1_failed == true || $img2_failed == true) {
            if($img1_failed == true && $img2_failed == false) {
                $response = array(
                    "status" => "success",
                    "message" => "Product successfully added. Failed to add Image",
                    "data" => $product_detail
                );
            } elseif ($img1_failed == false && $img2_failed == true) {
                $response = array(
                    "status" => "success",
                    "message" => "Product successfully added. Failed to add Image (Optional)",
                    "data" => $product_detail
                );
            } else {
                $response = array(
                    "status" => "success",
                    "message" => "Product successfully added. Failed to add Image & Image (Optional)",
                    "data" => $product_detail
                );
            }
        } else {
            $response = array(
                "status" => "success",
                "message" => "Product successfully added",
                "data" => $product_detail
            );
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