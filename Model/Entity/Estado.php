<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="estado")
 **/
class Estado
{
  /**
    * @Id @Column(name="id", type="integer") @GeneratedValue(strategy="AUTO")
   * @var integer
  */
    protected $id;
    /**
     * @Column(type="string", length=45)
     * @var string
    */
    protected $nombre;
    /**
     * @OneToMany(targetEntity="Pedido", mappedBy="estado_id")
    */
     protected $pedidos;

     public function __construct()
     {
         $this->pedidos = new ArrayCollection();
     }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
?>
