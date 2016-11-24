<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Rol;

/**
 * Class Resource
 * @package Model
 */
class RolResource extends AbstractResource {

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
            $roles = $this->getEntityManager()->getRepository('Model\Entity\Rol')->findAll();
            $data = $roles;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Rol', $id);
        }
        return $data;
    }
}

?>
