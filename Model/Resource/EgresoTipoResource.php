<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\EgresoTipo;
/**
 * Class Resource
 * @package Model
 */
class EgresoTipoResource extends AbstractResource {
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
            $egresoTipo = $this->getEntityManager()->getRepository('Model\Entity\EgresoTipo')->findAll();
            $data = $egresoTipo;}
         else {
            $data = $this->getEntityManager()->getRepository('Model\Entity\EgresoTipo')->findOneBy(array('id'=> $id));
        }
        return $data;
    }
    /*
    public function Nuevo ($productoID,$cantidad,$precio,$egresoTipoId){
        $egresoDetalle = new EgresoDetalle();
        $egresoDetalle->setProductoId(ProductoResource::getInstance()->get($productoID));
        $egresoDetalle->setCantidad($cantidad);
        $egresoDetalle->setPrecioUnitario($proveedor_cuit);
        $egresoDetalle->setEgresoTipoId($proveedor_cuit);
        $egresoDetalle->setFecha(new \DateTime('now')); 
        return $compra;
    }

    public function insert($proveedor,$proveedor_cuit){
        $this->getEntityManager()->persist($this->Nuevo($proveedor,$proveedor_cuit));
        $this->getEntityManager()->flush();
        return $this->get();
    }*/
}