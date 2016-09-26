<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;

class UsuarioController {

  public function listUsuarios($app){
    $userResource = new \Model\Resource\UsuarioResource();
    echo $app->view->render( "usuarios/index.twig", array('usuarios' => ($userResource->get())));
  }

}
