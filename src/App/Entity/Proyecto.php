<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="proyecto")
 *
 */
class Proyecto
{
	/**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
	protected $id;
     /**
     * @OneToMany(targetEntity="Item", mappedBy="proyecto")
     **/
    protected $items;
     /**
     * @OneToMany(targetEntity="Hora", mappedBy="proyecto")
     **/
    protected $horas;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->horas = new ArrayCollection();
    }
     /**
     * @ManyToOne(targetEntity="Cliente", inversedBy="proyecto", cascade={"merge"})
     * @JoinColumn(name="cliente_id", referencedColumnName="id")
     **/
     protected $cliente;

     /**
     * @var string
     * @Column(type="string", length=255)
     */
     protected $nombreProyecto;

     /**
     * @var string
     * @Column(type="string", length=255)
     */
     protected $descripcion;

	
     public function getId() {
          return $this->id;
     }

     public function getNombreProyecto() {
          return $this->nombreProyecto;
     }

     public function getDescripcion() {
          return $this->descripcion;
     }
     public function getCliente() {
          return $this->cliente;
     }
    public function getItems () {
        return $this->items;
    }
    public function getHoras () {
        return $this->horas;
    }
     public function getCantidadResponsables() {
          return $this->getClientes()->count();
     }

     public function setCliente($cliente) {
          $this->cliente=$cliente;
          return $this;
     }

     public function setNombreProyecto($nombreProyecto) {
          $this->nombreProyecto = $nombreProyecto;
          return $this;
     }
 
     public function setDescripcion($descripcion) {
          $this->descripcion = $descripcion;
          return $this;
     }



}



 ?>