<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\EgresoDetalle;
use Model\Resource\ProductoResource;
use Model\Resource\CompraResource;
use Model\Resource\EgresoTipoResource;
use Doctrine\DBAL\Types\Type;
/**
 * Class Resource
 * @package Model
 */
class EgresoDetalleResource extends AbstractResource {
    /**
     * @param $id
     *
     * @return string
     */
     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

    private function __construct() {}

    public function get($id = null)
    {
        if ($id === null) {
            $egresoDetalle = $this->getEntityManager()->getRepository('Model\Entity\EgresoDetalle')->findAll();
            $data = $egresoDetalle;}
         else {
            $data = $this->getEntityManager()->getRepository('Model\Entity\EgresoDetalle')->findOneBy(array('id'=> $id));
        }
        return $data;
    }
    public function Nuevo ($compra,$productoID,$cantidad,$precio,$egresoTipoId,$fecha){
        $egresoDetalle = new EgresoDetalle();
        $egresoDetalle->setCompra($compra);
        $egresoDetalle->setProducto(ProductoResource::getInstance()->get($productoID));
        $egresoDetalle->setCantidad($cantidad);
        $egresoDetalle->setPrecioUnitario($precio);
        $egresoDetalle->setEgresoTipoId(EgresoTipoResource::getInstance()->get($egresoTipoId));
        $egresoDetalle->setFecha($fecha); 
        return $egresoDetalle;
    }

    public function insert($compra,$productoID,$cantidad,$precio,$egresoTipoId,$fecha){
        $nuevoDetalle=$this->Nuevo($compra,$productoID,$cantidad,$precio,$egresoTipoId,$fecha);
        $compra->addDetalle($nuevoDetalle); 
        $this->getEntityManager()->persist($nuevoDetalle);
        $this->getEntityManager()->flush();
        return $nuevoDetalle;
    }
    public function delete($id){
        $detalle = $this->getEntityManager()->find('Model\Entity\EgresoDetalle', $id);
        $this->getEntityManager()->remove($detalle);
        $this->getEntityManager()->flush();
        return true;
    }
        public function getSumEgresontre($desde,$hasta)
    {
        $query_string = "
            SELECT sum(e.precio_unitario * e.cantidad) as y, e.fecha as name
            FROM Model\Entity\EgresoDetalle e
            WHERE e.fecha between :desde AND :hasta
            GROUP BY e.fecha
            ORDER by e.fecha asc ";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));
        return $query->getResult();
    }
}
?>