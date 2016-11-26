<?php

namespace Model\Resource;
use Model\Entity\Balance;
use Model\Entity\VentaProductos;
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
              SELECT b.fecha as name,b.ingreso as y FROM Model\Entity\Balance b
              WHERE b.fecha between :desde AND :hasta 
";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

        return $query->getResult();
  }
public function ventaProductosEntre($desde,$hasta)
  {
        $query_string = "
              SELECT CONCAT(p.nombre,'-',p.marca) as name,sum(v.cantidad) as y FROM Model\Entity\VentaProductos v join v.producto p
              WHERE v.fecha between :desde AND :hasta 
              GROUP BY v.producto
";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

        return $query->getResult();
  }
}
?>
