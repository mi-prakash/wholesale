<?php

class MyOrderContr extends MyOrder {

    private $user_id;
    private $product_id;
    private $created_at;
    private $updated_at;

    public function __construct($user_id, $product_id, $created_at = NULL, $updated_at = NULL)
    {
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        if ($created_at != NULL) {
            $this->created_at = $created_at;
        }
        if ($updated_at != NULL) {
            $this->updated_at = $updated_at;
        }
    }

    public function addMyOrder()
    {
        /* if ($this->emptyInput() == false) {
            $result = array(
                "status" => "error",
                "message" => "Please Input all the required fields"
            );
            return $result;
        } */

        // $product_id = $this->setProduct($this->name, $this->retail_price, $this->wholesale_price, $this->publish_by, $this->status, $this->created_at, $this->updated_at);

        // return $product_id;
    }

    public static function getMyOrders() 
    {
        $orders = MyOrder::getAllMyOrders();
        return $orders;
    }

}