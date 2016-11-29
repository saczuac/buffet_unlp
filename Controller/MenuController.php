<?php

namespace Controller;
use Model\Entity\Menu;
use Model\Resource\MenuResource;
use Model\Resource\ProductoResource;

class MenuController {

public function index($app,$token)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render("menus/menu.twig", array('menus' => (MenuResource::getInstance()->getByFecha()), 'productos' => (ProductoResource::getInstance()->getStock()),'token'=>$token));
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

  public function showEdit($app,$id,$token)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    $menu = MenuResource::getInstance()->get($id);
    $menus = MenuResource::getInstance()->getByFecha($menu->getFecha());
    $productos=[];
    foreach ($menus as $menu) {
      $productos[]= MenuResource::getInstance()->productoEntero($menu->getId());
    }
    echo $app->view->render( "menus/edit.twig", array('menu' => ($menu),'productos' => ($productos), 'allProductos' => (ProductoResource::getInstance()->get()),'token'=>$token));
  }

  public function nuevo($app, $productos, $fecha, $habilitado,$token)
  {  CSRF::getInstance()->control($app,$token);
    $algo=explode(",", $productos);
	  for ($i = 0; $i < (count($algo)/3) ; $i++) {
      $menu = MenuResource::getInstance()->insert($algo[$i*(3)], $fecha, $habilitado);
	   }
  	$this->index($app,$_SESSION['csrf_token']);
  }

  public function deleteMenu($app, $fecha) {
    MenuResource::getInstance()->deleteByFecha($fecha);
    $this->index($app);
  }

  public function edit($app,$productos,$fecha,$habilitado,$token)
  {
    MenuResource::getInstance()->deleteByFecha($fecha);
    $this->nuevo($app, $productos, $fecha, $habilitado,$token);
  }

}
