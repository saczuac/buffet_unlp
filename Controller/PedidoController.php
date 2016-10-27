<?php

namespace Controller;
use Model\Entity\Pedido;
use Model\Entity\PedidoDetalle;
use Model\Resource\PedidoResource;
use Model\Resource\PedidoDetalleResource;
use Model\Resource\MenuResource;

date_default_timezone_set('America/Argentina/Buenos_Aires');

class PedidoController {

public function index($app)
  {
    $hoy = date("y-m-d");
    $fecha = new \DateTime($hoy);
    $menus = MenuResource::getInstance()->getByFecha($fecha);
    $productos=[];
    foreach ($menus as $menu) {
      $productos[]= MenuResource::getInstance()->productoEntero($menu->getId());
    }
    echo $app->view->render("pedidos/pedidos.twig", array('pedidos' => (PedidoResource::getInstance()->get()), 'productos' => ($productos)));
  }

  public function showPedido($app, $id){
/* TODO: showPedido */
  	$this->index($app);
  }

  public function nuevo($app, $paramArray, $estado_id = 1, $observacion)
  {
    /*TODO: terminar detalle */
    $usuario_id = (isset($_SESSION['id'])) ? $_SESSION['id'] : null ;
    $app->applyHook('must.be.online');
    $pedido = PedidoResource::getInstance()->insert($usuario_id, 1, $observacion);
  	$algo=explode(",", $paramArray);
    if (count($algo)>=3) {
        for ($i = 0; $i < (count($algo)/3) ; $i++) {
        //  $nuevoDetalle=PedidoDetalleResource::getInstance()->insert($pedido,$algo[$i*(3)],$algo[($i*(3))+1]);
        }
    }
  	$this->index($app);
  }
}
