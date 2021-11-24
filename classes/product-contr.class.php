<?php

class ProductContr extends Product {

    private $name;
    private $retail_price;
    private $wholesell_price;
    private $image;
    private $image_2;
    private $publish_by;
    private $status;
    private $created_at;
    private $updated_at;

    public function __construct($name, $retail_price, $wholesell_price, $publish_by, $status, $created_at = NULL, $updated_at = NULL)
    {
        $this->name = $name;
        $this->retail_price = $retail_price;
        $this->wholesell_price = $wholesell_price;
        $this->publish_by = $publish_by;
        $this->status = $status;
        if ($created_at != NULL) {
            $this->created_at = $created_at;
        }
        if ($updated_at != NULL) {
            $this->updated_at = $updated_at;
        }
    }

    public function addProduct()
    {
        if ($this->emptyInput() == false) {
            $result = array(
                "status" => "error",
                "message" => "Please Input all the required fields"
            );
            return $result;
        }

        $product_id = $this->setProduct($this->name, $this->retail_price, $this->wholesell_price, $this->publish_by, $this->status, $this->created_at, $this->updated_at);

        return $product_id;
    }

    public function addImage($image_path, $product_id, $column_name)
    {
        return $this->setImage($image_path, $product_id, $column_name);
    }

    public static function getProducts() 
    {
        $products = Product::getSellerProducts();
        return $products;
    }

    public static function getProductById($id)
    {
        $product = Product::getSellerProductById($id);
        return $product;
    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->name) || empty($this->retail_price) || empty($this->status)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

}