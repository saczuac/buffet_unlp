<?php

namespace Controller;
use Controller\Validator;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Model\Resource\RolResource;
use Model\Entity\Ubicacion;
use Model\Entity\Rol;
use Model\Resource\UbicacionResource;

class UsuarioController {

  public function listUsuarios($app,$token){
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "usuarios/index.twig", array('usuarios' => (UsuarioResource::getInstance()->get()), 'ubicaciones' => (UbicacionResource::getInstance()->get()),'token'=>$token));
  }

  public function validarCampos($nombre, $apellido, $user, $pass = null, $email, $documento, $telefono) {
    $errors = [];
    if (!Validator::hasLength(45, $nombre)) {
         $errors[] = 'El nombre debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(45, $apellido)) {
         $errors[] = 'El apellido debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(45, $user)) {
         $errors[] = 'El username debe tener menos de 45 caracteres';
    }
    if ($pass != null) {
      if (!Validator::hasLength(20, $pass)) {
          $errors[] = 'La contraseña debe tener menos de 20 caracteres';
      }
      if (!Validator::hasNumbers($pass)) {
          $errors[] = 'La contraseña debe tener una combinación de números y caracteres';
      }
    }
    if(!Validator::isEmail($email)) {
        $errors[] = 'Debe ser un email válido';
    }
    if(!Validator::isNumeric($documento)) {
        $errors[] = 'El documento debe ser numérico';
    }
    if(!Validator::hasLength(8,$documento)) {
        $errors[] = 'El documento debe tener 8 números';
    }
    if(!Validator::isNumeric($telefono)) {
        $errors[] = 'El teléfono debe ser numérico';
    }
    return $errors;
  }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null, $habilitado = 1,$token) {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
    $errors = $this->validarCampos($nombre, $apellido, $user, $pass, $email, $documento, $telefono);
    if (sizeof($errors) == 0) {
        if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id, $habilitado)){
           $app->flash('success', 'El usuario ha sido dado de alta exitosamente');
       } else {
          $app->flash('error', 'No se pudo dar de alta el usuario');
      }
    } else {
       $app->flash('errors', $errors);
    }
    echo $app->redirect('/usuarios');
  }

  public function editUsuario($app,$user,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$id, $habilitado = 1,$token) {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
    $errors = $this->validarCampos($nombre, $apellido, $user, null, $email, $documento, $telefono);
    if (sizeof($errors) == 0) {
        if (UsuarioResource::getInstance()->edit($user,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id,$id, $habilitado)){
          $app->flash('success', 'El usuario ha sido modificado exitosamente');
        } else {
          $app->flash('error', 'No se pudo modificar el usuario');
        }
    } else {
        $app->flash('errors', $errors);
    }
    echo $app->redirect('/usuarios');
    }

  public function registrarUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id = 2,$email,$ubicacion_id = null, $habilitado = 0 ) {
    $errors = $this->validarCampos($nombre, $apellido, $user, $pass, $email, $documento, $telefono);
    if (sizeof($errors) == 0) {
        if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id, $habilitado)){
          $app->flash('success', 'El usuario ha sido registrado exitosamente');
        } else {
          $app->flash('error', 'No se pudo registrar el usuario');
        }
    } else {
        $app->flash('errors', $errors);
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

  public function showUsuario($app, $id,$token){
    $app->applyHook('must.be.administrador');
    $roles = RolResource::getInstance()->get();
    $user = UsuarioResource::getInstance()->get($id);
    $ubicacion = UsuarioResource::getInstance()->ubicacion($id);
    echo $app->view->render( "usuarios/show.twig", array('usuario' => ($user), 'ubicacionUser' => ($ubicacion), 'roles' => ($roles), 'ubicaciones' => (UbicacionResource::getInstance()->get()),'token'=>$token));
  }

}
