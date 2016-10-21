<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Menu;

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
}

?>
