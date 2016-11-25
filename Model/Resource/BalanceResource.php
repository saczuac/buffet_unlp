<?php

namespace Model\Resource;
use Model\Entity\Balance;
/**
 * Class Resource
 * @package Model
 */

class BalanceResource extends AbstractResource {

     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

    private function __construct() {}

      /**
       * @param $id
       *
       * @return string
       */
public function gananciasEntre($desde,$hasta)
  {
        $query_string = "
              SELECT fecha,ingresos FROM Model\Entity\Balance
              WHERE fecha between :desde AND :hasta 
";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

        return $query->getResult();
  }

}

?>
