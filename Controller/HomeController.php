<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Entity\Menu;
use Model\Resource\ConfiguracionResource;
use Model\Entity\Ubicacion;
use Model\Resource\UbicacionResource;
use Model\Resource\MenuResource;
use Model\Resource\ProductoResource;

date_default_timezone_set('America/Argentina/Buenos_Aires');

class HomeController {

   public function showHome($app){
    $configResource = ConfiguracionResource::getInstance();
    $infoMenu = MenuResource::getInstance()->hoy();
    ConfiguracionResource::getInstance()->edit('infoMenu',$infoMenu);
    echo $app->view->render( "home.twig",
     array('tituloDescripcion' => ($configResource->get('tituloDescripcion')),
      'infoDescripcion' => ($configResource->get('infoDescripcion')),
      'imgDescripcion' => ($configResource->get('imgDescripcion')),
      'tituloMenu' => ($configResource->get('tituloMenu')),
      'infoMenu' => ($configResource->get('infoMenu')),
      'imgMenu' => ($configResource->get('imgMenu')),
      'habilitado' => ($configResource->get('habilitado')),
      'msgDeshabilitado' => ($configResource->get('msgDeshabilitado')), 'ubicaciones' => (UbicacionResource::getInstance()->get())));
  }
}
?>
