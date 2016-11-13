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

    public function getPedidosDelUsuario ($id) {
      $query_string = "
          SELECT p FROM Model\Entity\Pedido p
          WHERE p.usuario_id = :idUser";
      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('idUser',$id);
      return $query->getResult();
    }

    public function getPedidosDelUsuarioEntreFechas($id, \Datetime $desde, \DateTime $hasta) {
      $f = new \DateTime($desde->format("Y-m-d")." 00:00:00");
      $h = new \DateTime($hasta->format("Y-m-d")." 23:59:59");
      $qb = $this->getEntityManager()->createQueryBuilder();
      $qb->select('p')
        ->from('Model\Entity\Pedido', 'p')
        ->where('p.fecha_alta >= :desde')
        ->andWhere('p.fecha_alta <= :hasta')
        ->andWhere('p.usuario_id <= :idUser')
        ->setParameter('desde', $f)
        ->setParameter('idUser', $id)
        ->setParameter('hasta', $h);
      return ($qb->getQuery()->getResult() == null);
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
    public function cancelar($id,$comentario)
    {
      $pedido=$this->get($id);
      $pedido->cancelar(EstadoResource::getInstance()->get(3),$comentario);
      $this->getEntityManager()->persist($pedido);
      $this->getEntityManager()->flush();
      return $pedido;
    }
    public function aceptar($id)
    {
      $pedido=$this->get($id);
      $pedido->setEstado_Id(EstadoResource::getInstance()->get(2));
      $hay=$this->controlarMiStock($id);
      if ($hay=0) {
            $this->sacarMiStock($id);
            $this->getEntityManager()->persist($pedido);
            $this->getEntityManager()->flush();
      return $pedido;
      } else {
        return false;
      }
      

    }
    public function sacarMiStock($id)
    {
      $pedido=$this->get($id);
      foreach ($pedido->getDetalles() as $detalle) {
        ProductoResource::getInstance()->sacarStock($detalle->getProducto_Id(),$detalle->getCantidad());
      }
      return $pedido;
    }

        public function getSumPedidos($desde,$hasta)
    {
        $query_string = "
            SELECT sum(pr.precio_venta_unitario * i.cantidad) as y, p.fecha_alta as name
            FROM Model\Entity\PedidoDetalle i join i.pedido_id p join i.producto_id pr  
            WHERE p.estado_id='2' AND p.fecha_alta between :desde AND :hasta
            GROUP BY p.fecha_alta
            ORDER by p.fecha_alta";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

        return $query->getResult();
    }

    public function getVentasEntre($desde,$hasta)
    {
        $query_string = "
            SELECT sum(d.cantidad) as y, CONCAT(p.nombre,'-',p.marca) as name
            FROM Model\Entity\Pedido i JOIN i.detalles d join d.producto_id p
            WHERE i.estado_id='2' AND d.producto_id=p.id AND i.fecha_alta between :desde AND :hasta 
            GROUP By d.producto_id
            ";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

        return $query->getResult();
    }
}

?>
