<?php

namespace Controller;
use Controller\Validator;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Categoria;
use Model\Resource\CategoriaResource;

class ProductoController {

  public function listProductos($app){
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render( "productos/index.twig", array('productos' => (ProductoResource::getInstance()->get()), 'categorias' => (CategoriaResource::getInstance()->get())));
  }

  public function newProducto($app,$nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion) {
  $app->applyHook('must.be.gestion.or.administrador');
    $errors = [];
    if (!Validator::hasLength(100, $nombre)) {
         $errors[] = 'El nombre debe tener menos de 100 caracteres';
    }
    if (!Validator::hasLength(45, $marca)) {
         $errors[] = 'La marca debe tener menos de 45 caracteres';
    }
    if (!Validator::isNumeric($stock)) {
         $errors[] = 'El stock debe ser un valor numérico';
    }
    if (!Validator::isNumeric($stock_minimo)) {
         $errors[] = 'El stock mínimo debe ser un valor numérico';
    }
    if (!Validator::isNumeric($precio_venta_unitario)) {
         $errors[] = 'El precio de venta unitario debe ser un valor numérico';
    }
    if (!Validator::hasLength(45, $proovedor)) {
         $errors[] = 'El nombre del proovedor debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(255, $descripcion)) {
         $errors[] = 'La descripcion debe tener menos de 200 caracteres';
    }
    if (sizeof($errors) == 0) {
      if (ProductoResource::getInstance()->insert($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id,$descripcion)){
        $app->flash('success', 'El producto ha sido dado de alta exitosamente');
      } else {
        $app->flash('error', 'No se pudo dar de alta el producto');
      }
    } else {
      $app->flash('errors', $errors);
    }
    echo $app->redirect('/productos');
  }

  public function editProducto($app,$nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion,$id) {
  $app->applyHook('must.be.gestion.or.administrador');
    $errors = [];
    if (!Validator::hasLength(100, $nombre)) {
         $errors[] = 'El nombre debe tener menos de 100 caracteres';
    }
    if (!Validator::hasLength(45, $marca)) {
         $errors[] = 'La marca debe tener menos de 45 caracteres';
    }
    if (!Validator::isNumeric($stock)) {
         $errors[] = 'El stock debe ser un valor numérico';
    }
    if (!Validator::isNumeric($stock_minimo)) {
         $errors[] = 'El stock mínimo debe ser un valor numérico';
    }
    if (!Validator::isNumeric($precio_venta_unitario)) {
         $errors[] = 'El precio de venta unitario debe ser un valor numérico';
    }
    if (!Validator::hasLength(45, $proovedor)) {
         $errors[] = 'El nombre del proovedor debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(255, $descripcion)) {
         $errors[] = 'La descripcion debe tener menos de 200 caracteres';
    }
    if (sizeof($errors) == 0) {
      if (ProductoResource::getInstance()->edit($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id,$descripcion,$id)){
        $app->flash('success', 'El producto ha sido modificado exitosamente');
      } else {
        $app->flash('error', 'No se pudo modificar el producto');
      }
    } else {
      $app->flash('errors', $errors);
    }
    echo $app->redirect('/productos');
  }

  public function deleteProducto($app, $id) {
  $app->applyHook('must.be.gestion.or.administrador');
    try {
      if (ProductoResource::getInstance()->delete($id)) {
        $app->flash('success', 'El producto ha sido eliminado exitosamente.');
      } else {
        $app->flash('error', 'No se pudo eliminar el producto');
      }
    } catch (Exception $e) {
      $app->flash('error', 'No se pudo eliminar el producto, se encuentra asociado en otras entidades');
    }
    $app->redirect('/productos');
  }

  public function showProducto($app, $id){
  $app->applyHook('must.be.gestion.or.administrador');
    $producto = ProductoResource::getInstance()->get($id);
    $categoria = ProductoResource::getInstance()->categoria($id);
    echo $app->view->render( "productos/show.twig", array('producto' => ($producto), 'categoriaProd' => ($categoria), 'categorias' => (CategoriaResource::getInstance()->get())));
  }

}
