<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Menu;

date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * Class Resource
 * @package Model
 */
class MenuResource extends AbstractResource {

     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

    private function __construct() {}

      /**
       * @param $id
       *
       * @return string
       */
    public function get($id = null)
    {
        if ($id === null) {
            $menus = $this->getEntityManager()->getRepository('Model\Entity\Menu')->findAll();
            $data = $menus;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Menu', $id);
        }
        return $data;
    }

    public function Nuevo ($producto_id, $fecha, $habilitado = 1){
        $menu = new Menu();
        $producto = ProductoResource::getInstance()->get($producto_id);
        $menu->setProducto_Id($producto);
        $menu->setFecha(new \DateTime($fecha));
        $menu->setHabilitado($habilitado);
        return $menu;
    }

    public function insert($producto_id, $fecha, $habilitado){
        $this->getEntityManager()->persist($this->Nuevo($producto_id, $fecha, $habilitado));
        $this->getEntityManager()->flush();
        return $this->get();
    }

  public function producto($id) {
    $menu = $this->getEntityManager()->getReference('Model\Entity\Menu', $id);
    $query_string = "
        SELECT p.nombre FROM Model\Entity\Producto p
        WHERE p.id = :idProd";
    $query = $this->getEntityManager()->createQuery($query_string);
    $idProd = $menu->getProducto_Id();
    $query->setParameter('idProd',$idProd);
    return $query->getResult();
  }

  public function hoy() {
    $hoy = date("y-m-d");
    $fecha = new \DateTime($hoy);
    $menus = $this->getByFecha($fecha);
    $productos=[];
    foreach ($menus as $menu) {
      $productos[]= $this->producto($menu->getId());
    }
    $infoMenu = "";
    foreach ($productos as $producto) {
      foreach ($producto as $productoi) {
        $infoMenu .= '* ' . $productoi["nombre"] . '-' . PHP_EOL;;
      }
    }
    return $infoMenu;
  }

  public function manana() {
    $manana = date("d-m-Y", time()+86400);
    $fecha = new \DateTime($manana);
    $menus = $this->getByFecha($fecha);
    $productos=[];
    foreach ($menus as $menu) {
      $productos[]= $this->producto($menu->getId());
    }
    $infoMenu = "";
    foreach ($productos as $producto) {
      foreach ($producto as $productoi) {
        $infoMenu .= '* ' . $productoi["nombre"] . '-' . PHP_EOL;;
      }
    }
    return $infoMenu;
  }

  public function getByFecha($fecha = null) {
    if ($fecha === null) {
      $query_string = "
          SELECT m FROM Model\Entity\Menu m
          GROUP BY m.fecha";
      $query = $this->getEntityManager()->createQuery($query_string);
      return $query->getResult();
    } else {
      $query_string = "
          SELECT m FROM Model\Entity\Menu m
          WHERE m.fecha = :fecha";
      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('fecha',$fecha);
      return $query->getResult();
    }
  }
}

?>
