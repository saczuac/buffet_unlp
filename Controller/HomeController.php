<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\configuracionResource;

class HomeController {

   public function showHome($app){
    $configResource = new \Model\Resource\ConfiguracionResource();
    echo $app->view->render( "home.twig",
     array('tituloDescripcion' => ($configResource->get('tituloDescripcion')),
      'infoDescripcion' => ($configResource->get('infoDescripcion')),
      'imgDescripcion' => ($configResource->get('imgDescripcion')),
      'tituloMenu' => ($configResource->get('tituloMenu')),
      'infoMenu' => ($configResource->get('infoMenu')),
      'imgMenu' => ($configResource->get('imgMenu'))));
  }
}
