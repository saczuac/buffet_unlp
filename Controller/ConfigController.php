<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\ConfiguracionResource;
use Controller\CSRF;

class ConfigController {

   public function showConfig($app,$token){
      $app->applyHook('must.be.administrador');
      $configResource = ConfiguracionResource::getInstance();
      echo $app->view->render( "config.twig",
       array('tituloDescripcion' => ($configResource->get('tituloDescripcion')),
      'infoDescripcion' => ($configResource->get('infoDescripcion')),
      'imgDescripcion' => ($configResource->get('imgDescripcion')),
      'tituloMenu' => ($configResource->get('tituloMenu')),
      'infoMenu' => ($configResource->get('infoMenu')),
      'imgMenu' => ($configResource->get('imgMenu')),
      'paginacion' => ($configResource->get('paginacion')),
      'msg' => ($configResource->get('msgDeshabilitado')),
      'mail' => ($configResource->get('mail')),
      'habilitado' => ($configResource->get('habilitado')),
      'token' => $token ));
  }

 public function setPaginacion($app,$value,$token) {
    $app->applyHook('must.be.administrador');
    CSRF::getInstance()->control($app,$token);
    ConfiguracionResource::getInstance()->edit('paginacion',$value);
    echo $app->redirect('/config');
  }

public function setTituloDescripcion($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('tituloDescripcion',$value);
 }

  public function setInfoDescripcion($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('infoDescripcion',$value);}    

  public function setImgDescripcion($app) {
    $app->applyHook('must.be.administrador');
  	if (isset($_FILES["myFileInfo"])) {
  	     $target_path = "uploads/";
	        $target_path = $target_path . basename( $_FILES["myFileInfo"]['name']); move_uploaded_file($_FILES["myFileInfo"]['tmp_name'], $target_path);
            ConfiguracionResource::getInstance()->edit('imgDescripcion',$target_path);
    }
  }

 public function setDescripcion($app,$titulo,$descripcion,$mail,$token) {
  CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
  	$this->setTituloDescripcion($app,$titulo);
  	$this->setInfoDescripcion($app,$descripcion);
    $this->setMail($app,$mail);
  	$this->setImgDescripcion($app);
    echo $app->redirect('/config');
 }

 public function setTituloMenu($app,$value) {
    ConfiguracionResource::getInstance()->edit('tituloMenu',$value);
 }

 public function setInfoMenu($app,$value) {
    ConfiguracionResource::getInstance()->edit('infoMenu',$value);
 }

public function setImgMenu($app) {
    if (isset($_FILES["myFileMenu"])) {
  	$target_dir = "uploads/";
	$target_file = $target_dir .  basename( $_FILES["myFileMenu"]["name"]);
    move_uploaded_file($_FILES["myFileMenu"]["tmp_name"], $target_file);
    ConfiguracionResource::getInstance()->edit('imgMenu',$target_file);
	}
  }
  public function setMenu($app,$titulo,$descripcion,$token) {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
  	$this->setTituloMenu($app,$titulo);
  	$this->setInfoMenu($app,$descripcion);
  	$this->setImgMenu($app);
    echo $app->redirect('/config');
  }
  public function setHabilitad($app,$value) {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('habilitado',$value);
  }
  public function setMail($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('mail',$value);
    $app->view->getEnvironment()->addGlobal('mail', $value);
  }
  public function setMsgDeshanilitado($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('msgDeshabilitado',$value);
  }
  public function setFormHabilitado($app,$estado,$msg,$token) {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
    if ($estado!=1) {
      $estado=0;
    }else{

    }
    $this->setHabilitad($app,$estado);
    $this->setMsgDeshanilitado($app,$msg);
    echo $app->redirect('/config');
  }

}
?>
