<?php 
require_once "./core/Database.php";
    class BaseModel{
        protected $db;
        public function __construct(){
            $this->db = Database::get_instance()->getConn();
        }
    }