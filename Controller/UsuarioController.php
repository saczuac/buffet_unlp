<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;

class UsuarioController {

  public function listUsuarios($app){
    $app->applyHook('must.be.administrador');
    $userResource = new \Model\Resource\UsuarioResource();
    echo $app->view->render( "usuarios/index.twig", array('usuarios' => ($userResource->get())));
  }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id ) {
    $app->applyHook('must.be.administrador');
    $userResource = new \Model\Resource\UsuarioResource();
    $userResource->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id);
    echo $app->redirect('/usuarios');
  }

}
