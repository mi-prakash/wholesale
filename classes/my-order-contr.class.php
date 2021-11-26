<?php

class MyOrderContr extends MyOrder {

    private $user_id;
    private $product_id;
    private $price;
    private $created_at;
    private $updated_at;

    public function __construct($user_id, $product_id, $price, $created_at = NULL, $updated_at = NULL)
    {
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->price = $price;
        if ($created_at != NULL) {
            $this->created_at = $created_at;
        }
        if ($updated_at != NULL) {
            $this->updated_at = $updated_at;
        }
    }

    public function addMyOrder()
    {
        $add_order = $this->setMyOrder($this->user_id, $this->product_id, $this->price, $this->created_at, $this->updated_at);
        return $add_order;
    }

    public static function getMyOrders() 
    {
        $orders = MyOrder::getAllMyOrders();
        return $orders;
    }

    public function checkOrderValid()
    {
        $check_order = $this->checkOrderIsValid($this->user_id, $this->product_id);
        return $check_order;
    }

}