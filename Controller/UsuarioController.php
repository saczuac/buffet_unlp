<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;

class UsuarioController {

  public function listUsuarios($app){
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "usuarios/index.twig", array('usuarios' => (UsuarioResource::getInstance()->get())));
  }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion ) {
    $app->applyHook('must.be.administrador');
    if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion)){
       $app->flash('success', 'El usuario ha sido dado de alta exitosamente');
    } else {
      $app->flash('error', 'No se pudo dar de alta el usuario');
    }
    echo $app->redirect('/usuarios');
  }

  public function registrarUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id = 2,$email,$ubicacion ) {
    if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion)){
       $app->flash('success', 'El registro se ha realizado con éxito');
    } else {
      $app->flash('error', 'No se pudo dar de alta el usuario');
    }
    echo $app->redirect('/');
  }

  public function deleteUsuario($app, $id) {
    $app->applyHook('must.be.administrador');
    if (UsuarioResource::getInstance()->delete($id)) {
      $app->flash('success', 'El usuario ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el usuario');
    }
    $app->redirect('/usuarios');
  }

}
