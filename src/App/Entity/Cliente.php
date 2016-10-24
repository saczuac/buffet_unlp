<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="cliente")
 */
class Cliente {
	/**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToMany(targetEntity="Proyecto", mappedBy="cliente")
     **/
    protected $proyectos;

    /**
     * @OneToMany(targetEntity="Hora", mappedBy="cliente")
     **/
    protected $horas;

    public function __construct()
    {
        $this->proyectos = new ArrayCollection();
        $this->horas = new ArrayCollection();
    }

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $nombreCliente;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $descripcion;

    /**
     * @var date
     * @Column(type="date")
     */
    protected $fechaIngreso;


    public function getId () {
        return $this->id;
    }
    public function getProyectos () {
        return $this->proyectos;
    }
    public function getNombreCliente () {
        return $this->nombreCliente;
    }

    public function getDescripcion() {
          return $this->descripcion;
     }

         public function getFechaIngreso () {
        return $this->fechaIngreso;
    }

    public function getFechaEgreso () {
        return $this->fechaEgreso;
    }
    public function getHoras () {
        return $this->horas;
    }
    public function addProyect(Proyecto $proyecto) {
          $this->proyectos->add($proyecto);
          return $this;
     }

    public function setNombreCliente ($nombreCliente) {
        return $this->nombreCliente = $nombreCliente;
    }

     public function setDescripcion($descripcion) {
          $this->descripcion = $descripcion;
          return $this;
     }

    public function setFechaIngreso ($fechaIngreso) {
        return $this->fechaIngreso = $fechaIngreso;
    }

    public function setFechaEgreso ($fechaEgreso) {
        return $this->fechaEgreso = $fechaEgreso;
    }

    public function removeProyecto($proyecto) {
        return $this->getProyectos()->removeElement($proyecto);
    }
}

?>