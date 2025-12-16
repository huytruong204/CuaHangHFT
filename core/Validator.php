<?php
    class Validator{
        public static function required($value, $mess){
            return empty($value) ? $mess : '';
        }
        public static function numeric($value, $mess){
            return !is_numeric($value) ? $mess : '';
        }
        public static function is_isset($value, $mess){
            return !isset($value) ? $mess : '';
        }
    }
?>