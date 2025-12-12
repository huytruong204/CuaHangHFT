<?php
include_once '../core/BaseModel.php';
class FoodModel extends BaseModel
{
        private const TB_NAME = "foods";
        protected $food_id;
        protected $category_id;
        protected $food_name;
        protected $description;
        protected $price;
        protected $image_url;
        protected $status;
        protected $created_at;
        
        public function __construct()
        {
                parent::__construct(self::TB_NAME);
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

        public function getCategory_id()
        {
                return $this->category_id;
        }


        public function setCategory_id($category_id)
        {
                $this->category_id = $category_id;

                return $this;
        }

        public function getFood_name()
        {
                return $this->food_name;
        }

        public function setFood_name($food_name)
        {
                $this->food_name = $food_name;

                return $this;
        }

        public function getDescription()
        {
                return $this->description;
        }


        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        public function getPrice()
        {
                return $this->price;
        }


        public function setPrice($price)
        {
                $this->price = $price;

                return $this;
        }

        public function getImage_url()
        {
                return $this->image_url;
        }

        public function setImage_url($image_url)
        {
                $this->image_url = $image_url;

                return $this;
        }

        public function getStatus()
        {
                return $this->status;
        }


        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        public function getCreated_at()
        {
                return $this->created_at;
        }
}
