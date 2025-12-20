<?php
class OrderItem extends BaseModel
{
    public const TB_NAME = "order_items";
    protected  $order_item_id;
    protected  $order_id;
    protected  $food_id;
    protected  $quantity;
    protected  $price_at_purchase;
    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);

        if (!empty($data)) {
            $this->order_item_id      = $data['order_item_id'] ?? null;
            $this->order_id           = $data['order_id'] ?? null;
            $this->food_id            = $data['food_id'] ?? null;
            $this->quantity           = $data['quantity'] ?? null;
            $this->price_at_purchase  = $data['price_at_purchase'] ?? null;
        }
    }
    public function getOrder_item_id()
    {
        return $this->order_item_id;
    }

    public function setOrder_item_id($order_item_id)
    {
        $this->order_item_id = $order_item_id;

        return $this;
    }

   
    public function getOrder_id()
    {
        return $this->order_id;
    }


    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

  
    public function getFood_id()
    {
        return $this->food_id;
    }
    public function setFood_id($food_id)
    {
        $this->food_id = $food_id;

        return $this;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice_at_purchase()
    {
        return $this->price_at_purchase;
    }

    public function setPrice_at_purchase($price_at_purchase)
    {
        $this->price_at_purchase = $price_at_purchase;

        return $this;
    }
}
