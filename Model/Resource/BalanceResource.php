<?php

namespace Model\Resource;
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
              SELECT sum(result) 
              FROM ( (SELECT IFNULL(i.cantidad*i.precio_unitario,0) -IFNULL(e.cantidad*e.precio_unitario,0)as result ,ifnull(e.fecha,i.fecha) as thatfecha 
              FROM egreso_detalle e right join ingreso_detalle i on i.fecha=e.fecha
              WHERE i.fecha between :desde AND :hasta) 
              union (SELECT IFNULL(i.cantidad*i.precio_unitario,0) -IFNULL(e.cantidad*e.precio_unitario,0)as result ,ifnull(e.fecha,i.fecha) as thatfecha 
              FROM egreso_detalle e left join ingreso_detalle i on i.fecha=e.fecha
              WHERE e.fecha between :desde AND :hasta))as xx group by thatfecha
";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

        return $query->getResult();
  }

}

?>
