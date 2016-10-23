<?php

namespace Controller;
use Model\Entity\Menu;
use Model\Resource\MenuResource;
use Model\Resource\ProductoResource;

class MenuController {

public function index($app)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render("menus/menu.twig", array('menus' => (MenuResource::getInstance()->getByFecha()), 'productos' => (ProductoResource::getInstance()->get())));
  }

  public function showFecha($app, $fecha){
    $app->applyHook('must.be.gestion.or.administrador');
    $menus = MenuResource::getInstance()->getByFecha($fecha);
    $productos=[];
    foreach ($menus as $menu) {
      $productos[]= MenuResource::getInstance()->producto($menu->getId());
    }
    echo $app->view->render( "menus/show.twig", array('productos' => ($productos), 'fecha' => ($fecha)));
  }

/* TODO: Hacer show de lista de productos con AJAX
  public function show($app,$id)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render( "menus/show.twig", array('compra' => (CompraResource::getInstance()->get($id))));
  }
*/

  public function nuevo($app,$productos, $fecha, $habilitado)
  {
    $algo=explode(",", $productos);
	  for ($i = 0; $i < (count($algo)/3) ; $i++) {
      $menu = MenuResource::getInstance()->insert($algo[$i*(3)], $fecha, $habilitado);
	   }
  	$this->index($app);
  }

}
