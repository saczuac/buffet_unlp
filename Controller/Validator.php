<?php

namespace Controller;

class Validator {
     // Singleton of Validator
     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

     private function __construct() {}
   // Validators..
     public function isEmail ($value) {
         $response = true;
         if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
             $response = false;
         }
         return $response;
     }

     public function isNumeric ($value) {
         return is_numeric($value);
     }
     public function isPositive($value)
     {
         return (Validator::isNumeric($value)&&($value>0));
     }

     public function hasLength($number,$value) {
        return (strlen($value) <= $number);
     }

     public function hasNumbers($value) {
        return preg_match("#[0-9]+#",$value);
     }
      public function isDate($value) {
        $fechaExplode=explode("/",$value);
        if (sizeof($fechaExplode)==3){
            return (checkdate($fechaExplode[0],$fechaExplode[1],$fechaExplode[2]));
        }else{return false;}
     }

}


?>
