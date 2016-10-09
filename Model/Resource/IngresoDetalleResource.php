<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\IngresoDetalle;
use Model\Resource\ProductoResource;
use Model\Resource\CompraResource;
use Model\Resource\IngresoTipoResource;
use Doctrine\DBAL\Types\Type;
/**
 * Class Resource
 * @package Model
 */
class IngresoDetalleResource extends AbstractResource {
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
            $egresoDetalle = $this->getEntityManager()->getRepository('Model\Entity\IngresoDetalle')->findAll();
            $data = $egresoDetalle;}
         else {
            $data = $this->getEntityManager()->getRepository('Model\Entity\IngresoDetalle')->findOneBy(array('id'=> $id));
        }
        return $data;
    }
    public function Nuevo ($productoID,$cantidad,$precio,$ingresoTipoId,$fecha,$desc){
        $ingresoDetalle = new IngresoDetalle();
        $ingresoDetalle->setProducto(ProductoResource::getInstance()->get($productoID));
        $ingresoDetalle->setCantidad($cantidad);
        $ingresoDetalle->setPrecioUnitario($precio);
        $ingresoDetalle->setIngresoTipoId(IngresoTipoResource::getInstance()->get($ingresoTipoId));
        $ingresoDetalle->setFecha(new \DateTime($fecha));
        $ingresoDetalle->setDescripcion($desc);
        return $ingresoDetalle;
    }

    public function insert($productoID,$cantidad,$precio,$egresoTipoId,$fecha,$desc){
        $nuevoIngDetalle=$this->Nuevo($productoID,$cantidad,$precio,$egresoTipoId,$fecha,$desc); 
        $this->getEntityManager()->persist($nuevoIngDetalle);
        $this->getEntityManager()->flush();
        return $nuevoIngDetalle;
    }
    public function edit ($id,$productoID,$cantidad,$precio,$ingresoTipoId,$fecha,$desc){
        $ingresoDetalle = $this->getEntityManager()->find('Model\Entity\IngresoDetalle', $id);
        $ingresoDetalle->setProducto(ProductoResource::getInstance()->get($productoID));
        $ingresoDetalle->setCantidad($cantidad);
        $ingresoDetalle->setPrecioUnitario($precio);
        $ingresoDetalle->setIngresoTipoId(IngresoTipoResource::getInstance()->get($ingresoTipoId));
        $ingresoDetalle->setFecha(new \DateTime($fecha));
        $ingresoDetalle->setDescripcion($desc);
        $this->getEntityManager()->persist($ingresoDetalle);
        $this->getEntityManager()->flush();
        return $ingresoDetalle;
    }
    public function delete($id){
        $ingresoDetalle = $this->getEntityManager()->find('Model\Entity\IngresoDetalle', $id);
        $this->getEntityManager()->remove($ingresoDetalle);
        $this->getEntityManager()->flush();
        return true;
    }
}
?>