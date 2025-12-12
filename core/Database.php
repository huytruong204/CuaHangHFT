<?php
    class Database{
        private static $instance;
        private const DB_USER = "root";
        private const DB_PASSWORD = "";
        private const DB_HOST = "localhost";
        private const DB_NAME = "ql_shophft";
        private $conn;
        private function __construct()
        {
            try {
                $this->conn = new PDO("mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME, self::DB_USER, self::DB_PASSWORD);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        public static function get_instance(){
            if(self::$instance == null)
                self::$instance = new Database();
            return self::$instance;
        }

        public function getConn()
        {
                return $this->conn;
        }
    }
