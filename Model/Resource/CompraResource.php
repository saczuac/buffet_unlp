<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Compra;
use Model\Resource\EgresoDetalleResource;
/**
 * Class Resource
 * @package Model
 */
class CompraResource extends AbstractResource {
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
            $Compra = $this->getEntityManager()->getRepository('Model\Entity\Compra')->findAll();
            $data = $Compra;}
         else {
            $data = $this->getEntityManager()->getRepository('Model\Entity\Compra')->findOneBy(array('id'=> $id));
        }
        return $data;
    }
    public function Nuevo ($proveedor,$proveedor_cuit){
        $compra = new Compra();
        $compra->setProveedor($proveedor);
        $compra->setProveedorCuit($proveedor_cuit);
        $compra->setFecha(new \DateTime('now')); 
        return $compra;
    }
    public function Edit ($id,$proveedor,$proveedor_cuit){
        $compra = $this->getEntityManager()->find('Model\Entity\Compra', $id);
        echo $proveedor;
        $compra->setProveedor($proveedor);
        $compra->setProveedorCuit($proveedor_cuit);
        $this->getEntityManager()->persist($compra);
        $this->getEntityManager()->flush();
        return $compra;
    }
    public function insert($proveedor,$proveedor_cuit){
        $nuevaCompra=$this->Nuevo($proveedor,$proveedor_cuit);
        $this->getEntityManager()->persist($nuevaCompra);
        $this->getEntityManager()->flush();
        return $nuevaCompra;
    }
    public function deleteAllDetalles($id){
        $compra=$this->getEntityManager()->find('Model\Entity\Compra', $id);
        $array=$compra->getDetalles();
        foreach ($array as &$valor) {
            EgresoDetalleResource::getInstance()->delete($valor->getId());
        }
    }
    public function delete($id){
        $compra = $this->getEntityManager()->find('Model\Entity\Compra', $id);
        $this->getEntityManager()->remove($compra);
        $this->getEntityManager()->flush();
        return true;
    }
}
?>