<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\configuracionResource;

class ConfigController {

   public function showConfig($app){
    $configResource = new \Model\Resource\ConfiguracionResource();
    echo $app->view->render( "config.twig",
     array('tituloDescripcion' => ($configResource->get('tituloDescripcion')),
      'infoDescripcion' => ($configResource->get('infoDescripcion')),
      'imgDescripcion' => ($configResource->get('imgDescripcion')),
      'tituloMenu' => ($configResource->get('tituloMenu')),
      'infoMenu' => ($configResource->get('infoMenu')),
      'imgMenu' => ($configResource->get('imgMenu'))));
  }

  public function setPaginacion($app,$value) {
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('paginacion',$value);
    echo $app->redirect('/config');
  }
    public function setTituloDescripcion($app,$value) {
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('tituloDescripcion',$value);
  }
  public function setInfoDescripcion($app,$value) {
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('infoDescripcion',$value);
  }
  public function setImgDescripcion($app) {
  	if (isset($_FILES["myFileInfo"])) {
  	$target_path = "img/";
	$target_path = $target_path . basename( $_FILES["myFileInfo"]['name']); move_uploaded_file($_FILES["myFileInfo"]['tmp_name'], $target_path);
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('imgDescripcion',$target_path);}
  }
  public function setDescripcion($app,$titulo,$descripcion) {
  	$this->setTituloDescripcion($app,$titulo);
  	$this->setInfoDescripcion($app,$descripcion);
  	$this->setImgDescripcion($app);
    echo $app->redirect('/config');
  }
  public function setTituloMenu($app,$value) {
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('tituloMenu',$value);
  }
  public function setInfoMenu($app,$value) {
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('infoMenu',$value);
  }
    public function setImgMenu($app) {
    if (isset($_FILES["myFileMenu"])) {
  	$target_path = "img/";
	$target_path = $target_path .  basename( $_FILES["myFileMenu"]['name']); move_uploaded_file($_FILES["myFileMenu"]['tmp_name'], $target_path);
    $configResource = new \Model\Resource\ConfiguracionResource();
    $configResource->edit('imgMenu',$target_path);
	}
  }
  public function setMenu($app,$titulo,$descripcion) {
  	$this->setTituloMenu($app,$titulo);
  	$this->setInfoMenu($app,$descripcion);
  	$this->setImgMenu($app);
    echo $app->redirect('/config');
  }

}
