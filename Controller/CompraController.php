<?php

namespace Controller;
use Model\Entity\Compra;
use Model\Resource\CompraResource;
use Model\Resource\ProductoResource;
use Model\Resource\EgresoDetalleResource;
class CompraController {

public function index($app)
  {
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "compras/compras.twig", array('compras' => (CompraResource::getInstance()->get()),'productos' => (ProductoResource::getInstance()->get()),'comprad' => (CompraResource::getInstance()->get(50))));
  }
  public function show($app,$id)
  {
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "compras/show.twig", array('compra' => (CompraResource::getInstance()->get($id))));
  }
  public function edit($app,$id)
  {
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "compras/edit.twig", array('compra' => (CompraResource::getInstance()->get($id)),'productos' => (ProductoResource::getInstance()->get())));
  }
  public function addFactura($app,$id)
  {
    if (isset($_FILES["myFileMenu"])){
         $target_path = "uploads/";
          $target_path = $target_path . basename( $_FILES["myFileMenu"]['name']);
           move_uploaded_file($_FILES["myFileMenu"]['tmp_name'], $target_path);
           CompraResource::getInstance()->addFactura($id,$target_path);
    }
    $app->redirect("/compras");
  }
    public function factura($app,$id)
  {
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "compras/factura.twig", array('compra' => (CompraResource::getInstance()->get($id))));
  }
  public function nuevo($app,$proveedor,$cuil,$paramArray)
  {
    $target_file ="";
    if (isset($_FILES["factura"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir .  basename( $_FILES["factura"]["name"]);
        move_uploaded_file($_FILES["factura"]["tmp_name"], $target_file);
    }
  	$compra=CompraResource::getInstance()->insert($proveedor,$cuil,$target_file);
  	$algo=explode(",", $paramArray);
    if (count($algo)>=3) {
        for ($i = 0; $i < (count($algo)/3) ; $i++) {
    $nuevoDetalle=EgresoDetalleResource::getInstance()->insert($compra,$algo[$i*(3)],$algo[($i*(3))+1],$algo[($i*(3))+2],1,$compra->getFecha());

    ProductoResource::getInstance()->ingresarStock($algo[$i*(3)],$algo[($i*(3))+1]);
    }
  }
    

  	$this->index($app);
  }
  public function borrarMisDetalles($id)
  {

  }
  public function editar($app,$id,$proveedor,$cuil,$paramArray)
  {
    $compra=CompraResource::getInstance()->get($id);
    $algo=explode(",", $paramArray);
    CompraResource::getInstance()->edit($id,$proveedor,$cuil);
    CompraResource::getInstance()->deleteAllDetalles($id);
  for ($i = 0; $i < (count($algo)/3) ; $i++) {
    $nuevoDetalle=EgresoDetalleResource::getInstance()->insert($compra,$algo[$i*(3)],$algo[($i*(3))+1],$algo[($i*(3))+2],1,$compra->getFecha());

    ProductoResource::getInstance()->ingresarStock($algo[$i*(3)],$algo[($i*(3))+1]);

  } 
    $this->index($app);
  }
  public function delete($app,$id)
  {
    $app->applyHook('must.be.administrador');
    CompraResource::getInstance()->deleteAllDetalles($id);    
    CompraResource::getInstance()->delete($id);
    $app->redirect("/compras");
  }
}
