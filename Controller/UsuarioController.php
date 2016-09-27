<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
require_once('Model/Resource/UsuarioResource.php');

class UsuarioController {

  public function listUsuarios($app){
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "usuarios/index.twig", array('usuarios' => (UsuarioResource::getInstance()->get())));
  }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id ) {
    $app->applyHook('must.be.administrador');
    UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id);
    echo $app->redirect('/usuarios');
  }

  public function deleteUsuario($app) {
    $app->applyHook('must.be.administrador');
    $id = $_SESSION["element_id"];
    UsuarioResource::getInstance()->delete($id);
    unset($_SESSION['element_id']);
    $app->flash('success', 'El usuario ha sido eliminado exitosamente.');
    header("Refresh:0");
  }

}
