<?php

namespace Controller;
use Model\Entity\Compra;
use Model\Resource\CompraResource;
use Model\Resource\ProductoResource;
use Model\Resource\IngresoDetalleResource;

class VentasController {

public function index($app)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render("ventas/ventas.twig",array('ingresos' => (IngresoDetalleResource::getInstance()->get()),'productos' => (ProductoResource::getInstance()->get())));
  }

public function edit($app,$id)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render( "ventas/edit.twig", array('ingreso' => (IngresoDetalleResource::getInstance()->get($id)),'productos' => (ProductoResource::getInstance()->get())));
  }

  public function editar($app,$id,$productoID,$cantidad,$precio,$egresoTipoId,$fecha,$desc)
  {
    $app->applyHook('must.be.gestion.or.administrador');
    $ingreso=IngresoDetalleResource::getInstance()->get($id);
    ProductoResource::getInstance()->ingresarStock($ingreso->getProducto()->getId(),$ingreso->getCantidad());
    IngresoDetalleResource::getInstance()->edit($id,$productoID,$cantidad,$precio,$egresoTipoId,$fecha,$desc);
    $app->redirect("/ventas");
  }

  public function delete($app,$id)
  {
    $app->applyHook('must.be.gestion.or.administrador');
        $ingreso=IngresoDetalleResource::getInstance()->get($id);
    ProductoResource::getInstance()->ingresarStock($ingreso->getProducto()->getId(),$ingreso->getCantidad());
    IngresoDetalleResource::getInstance()->delete($id);
    $app->redirect("/ventas");
  }

public function nuevo($app,$productoID,$cantidad,$precio,$egresoTipoId,$fecha,$desc)
  {$app->applyHook('must.be.gestion.or.administrador');
    if ($cantidad < ProductoResource::getInstance()->get($productoID)->getStock()) {
        $app->flash('error', $cantidad >= ProductoResource::getInstance()->get($productoID)->getStock());
          IngresoDetalleResource::getInstance()->insert($productoID,$cantidad,$precio,$egresoTipoId,$fecha,$desc);
          ProductoResource::getInstance()->sacarStock($productoID,$cantidad);
          $app->redirect("/ventas");
    } else {
      $app->flash('error', 'No hay suficiente stock');
    }
    $app->redirect("/ventas");
    

  }

}
