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
      if ($menu->getHabilitado() == 1) {
        $productos[]= MenuResource::getInstance()->productoEntero($menu->getId());
      }
     }
    echo $app->view->render("pedidos/pedidos.twig", array('pedidos' => (PedidoResource::getInstance()->get()), 'productos' => ($productos)));
  }

  public function show($app, $id){
    $detalles = PedidoDetalleResource::getInstance()->getByPedidoId($id);
    echo $app->view->render("pedidos/show.twig", array('detalles' => ($detalles)));
  }

  public function nuevo($app, $paramArray, $estado_id = 1, $observacion)
  {
  try {
    $usuario_id = (isset($_SESSION['id'])) ? $_SESSION['id'] : null ;
    $app->applyHook('must.be.online');
    $pedido = PedidoResource::getInstance()->insert($usuario_id, 1, $observacion);
  	$algo=explode(",", $paramArray);
    for ($i = 0; $i < (count($algo)) ; $i++) {
     $nuevoDetalle=PedidoDetalleResource::getInstance()->insert($pedido,array_shift($algo),array_shift($algo));
    }
  } catch (\Doctrine\DBAL\DBALException $e) {
      $app->flash('error', 'No se pudo dar de alta el pedido');
  }
  $this->index($app);
  }
}
