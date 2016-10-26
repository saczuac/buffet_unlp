<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Resource\ProductoResource;
use Model\Resource\PedidoResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\PedidoDetalle;
/**
 * Class Resource
 * @package Model
 */
class PedidoDetalleResource extends AbstractResource {

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
    public function get($id = null)
    {
        if ($id === null) {
            $detalles = $this->getEntityManager()->getRepository('Model\Entity\PedidoDetalle')->findAll();
            $data = $detalles;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\PedidoDetalle', $id);
        }
        return $data;
    }

    public function Nuevo ($pedido, $producto_id, $cantidad){
        $detalle = new PedidoDetalle();
        $producto = ProductoResource::getInstance()->get($producto_id);
        $detalle->setPedido_Id($pedido);
        $detalle->setProducto_Id($producto);
        $detalle->setCantidad($cantidad);
        return $detalle;
    }

    public function insert($pedido, $producto_id, $cantidad){
        $nuevoPedido=$this->Nuevo($pedido, $producto_id, $cantidad);
        $this->getEntityManager()->persist($nuevoPedido);
        $this->getEntityManager()->flush();
        return $nuevoPedido;
    }

}

?>
