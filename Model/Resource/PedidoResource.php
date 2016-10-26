<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Resource\UsuarioResource;
use Model\Resource\EstadoResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\Pedido;
/**
 * Class Resource
 * @package Model
 */
class PedidoResource extends AbstractResource {

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
            $pedidos = $this->getEntityManager()->getRepository('Model\Entity\Pedido')->findAll();
            $data = $pedidos;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Pedido', $id);
        }
        return $data;
    }

    public function Nuevo ($usuario_id, $estado_id = 1, $observacion){
        $pedido = new Pedido();
        $usuario = UsuarioResource::getInstance()->get($usuario_id);
        $estado = EstadoResource::getInstance()->get($estado_id);
        $pedido->setUsuario_Id($usuario);
        $pedido->setEstado_Id($estado);
        $pedido->setObservacion($observacion);
        $pedido->setFecha_Alta(new \DateTime('now'));
        return $pedido;
    }

    public function insert($usuario_id, $estado_id = 1, $observacion){
        $nuevoPedido=$this->Nuevo($usuario_id, $estado_id, $observacion);
        $this->getEntityManager()->persist($nuevoPedido);
        $this->getEntityManager()->flush();
        return $nuevoPedido;
    }
}

?>
