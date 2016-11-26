<?php

namespace Controller;
use Model\Entity\Pedido;
use Model\Entity\PedidoDetalle;
use Model\Resource\ProductoResource;
use Model\Resource\PedidoResource;
use Model\Resource\PedidoDetalleResource;
use Model\Resource\MenuResource;
use Exception;

date_default_timezone_set('America/Argentina/Buenos_Aires');

class PedidoController {

public function index($app, $misPedidos = null)
  {
    $app->applyHook('must.be.logueado');
    $hoy = date("y-m-d");
    $usuario_id = (isset($_SESSION['id'])) ? $_SESSION['id'] : null ;
    $fecha = new \DateTime($hoy);
    $menus = MenuResource::getInstance()->getByFecha($fecha);
    $productos=[];
    foreach ($menus as $menu) {
      if ($menu->getHabilitado() == 1) {
        $productos[]= MenuResource::getInstance()->productoEntero($menu->getId());
      }
     }
    if ($misPedidos == null) {
       $misPedidos = PedidoResource::getInstance()->getPedidosDelUsuario($usuario_id);
    }

    echo $app->view->render("pedidos/pedidos.twig", array('pedidos' => (PedidoResource::getInstance()->get()),'pedidosMios' => ($misPedidos) ,'productos' => ($productos)));
  }

  public function search($app, $desde, $hasta) {
    $usuario_id = (isset($_SESSION['id'])) ? $_SESSION['id'] : null ;
    $misPedidos = PedidoResource::getInstance()->getPedidosDelUsuarioEntreFechas($usuario_id, new \DateTime($desde), new \DateTime($hasta));
    $this->index($app, $misPedidos);
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
    $check = $this->checkStock($paramArray);
    if ($check) { 

      $pedido = PedidoResource::getInstance()->insert($usuario_id, 1, $observacion);
      setcookie('PEDIDO',$pedido->getId(), time() + 1800);
  	 $algo=explode(",", $paramArray);
      for ($i = 0; $i < (count($algo)) ; $i++) {
        $nuevoDetalle=PedidoDetalleResource::getInstance()->insert($pedido,array_shift($algo),array_shift($algo));
      }
    } else {
      $app->flash('error', 'La cantidad debe ser menor que el stock');
    }
  } catch (Exception $e){
    $app->flash('error', 'Se debe seleccionar algun producto y la cantidad no puede ser 0 o menor');
  } catch (\Doctrine\DBAL\DBALException $e) {
      $app->flash('error', 'No se pudo dar de alta el pedido');
  }
   echo $app->redirect('/pedidos');
  }


  public function cancelarOnline($app,$id,$comentario){
    if (PedidoResource::getInstance()->cancelable($id)){
        PedidoResource::getInstance()->cancelar($id,$comentario);
      }else{
        $app->flash('error', 'No puede cancelar este pedido ');
      }
      echo $app->redirect('/pedidos');
  }
  public function cancelar($app,$id,$comentario){
    
        if (PedidoResource::getInstance()->cancelar($id,$comentario)){
        $app->flash('success', 'El pedido fue Cancelado');}
    else{
        $app->flash('error', 'No se puede cancelar este pedido');
    }
    echo $app->redirect('/pedidos');
  }
  public function aceptar($app,$id){
    if (PedidoResource::getInstance()->aceptar($id)){
        $app->flash('success', 'El pedido fue entregado');}
    else{
        $app->flash('error', 'No hay estock suficiente');
    }
        echo $app->redirect('/pedidos');
  }

    public function checkStock($paramArray) {
    $algo=explode(",", $paramArray);
    $e = true;
    for ($i = 0; $i < (count($algo)) ; $i++) {
      $check = $this->checkProducto(array_shift($algo),array_shift($algo));
      if ($check) { 
        $e = false;
      }
    }
    return $e;
  }

  public function checkProducto($id, $cantidad) {
    $producto = ProductoResource::getInstance()->get($id);
    if ($producto == null) { 
      throw new Exception("No se seleccionaron productos", 1);
    }
    if(intval($cantidad) <= 0) {
      throw new Exception("No puede ser menor a 0 la cantidad", 1);
    }
    return ($cantidad > $producto->getStock());
  }
}
