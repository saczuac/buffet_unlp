<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity @Table(name="menu_del_dia")
 **/
class Menu
{
  /**
    * @Id @Column(name="id", type="integer") @GeneratedValue(strategy="AUTO")
    * @var integer
  */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Producto", inversedBy="menus")
     * @JoinColumn(name="producto_id", referencedColumnName="id")
     */
    protected $producto_id;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha;
    /**
     * @var integer
     * @Column(type="integer", length=1)
     */
    protected $habilitado;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setProducto_Id($id) {
        $this->producto_id = $id;
    }

    public function getProducto_Id() {
      return $this->$producto_id;
    }

    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    public function getHabilitado() {
      return $this->habilitado;
    }

    public function setFecha($fecha) {
      $this->fecha = $fecha;
    }

    public function getFecha() {
      return $this->fecha;
    }

}
?>
