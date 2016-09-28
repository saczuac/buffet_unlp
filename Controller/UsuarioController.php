<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\configuracionResource;

class UsuarioController {

  public function showHome($app){
    $configResource = new \Model\Resource\ConfiguracionResource();
    echo $app->view->render( "home.twig", array('titiloConfig' => ($configResource->get('tituloDescripcion'))));
  }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id ) {
    $userResource = new \Model\Resource\ConfiguracionResource();
    $userResource->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id);
    echo $app->redirect('/usuarios');
  }

}
