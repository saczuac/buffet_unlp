<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="item")
 */
class Item {
	/**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="Cliente")
     * @JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    protected $cliente;
    /**
     * @OneToOne(targetEntity="Proyecto")
     * @JoinColumn(name="proyecto_id", referencedColumnName="id")
     */
    protected $proyecto;
    /**
     * @OneToMany(targetEntity="Tarea", mappedBy="item")
     **/
    protected $tareas;

     /**
     * @OneToMany(targetEntity="Hora", mappedBy="item")
     **/
    protected $horas;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $nombreItem;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $descripcion;

    /**
     * @var date
     * @Column(type="date")
     */
    protected $fecha_inicio;

     /**
     * @var date
     * @Column(type="date")
     */
    protected $fecha_fin;

    public function __construct()
    {
        $this->tareas = new ArrayCollection();
        $this->horas = new ArrayCollection();
    }


    public function getId () {
        return $this->id;
    }
    public function getProyecto () {
        return $this->proyecto;
    }
    public function getCliente () {
        return $this->cliente;
    }
    public function getTareas () {
        return $this->tareas;
    }

    public function getDescripcion() {
          return $this->descripcion;
    }

    public function getNombreItem () {
        return $this->nombreItem;
    }

    public function getFechaInicio () {
        return $this->fecha_inicio;
    }
    public function getFechaFin () {
        return $this->fecha_fin;
    }
    public function setCliente ($idCliente) {
        return $this->cliente=$idCliente;
    }
    public function setProyecto ($idProyecto) {
        return $this->proyecto=$idProyecto;
    }

    public function setNombreItem ($nombreItem) {
        return $this->nombreItem = $nombreItem;
    }

     public function setDescripcion($descripcion) {
          $this->descripcion = $descripcion;
          return $this;
     }
    public function setFechaInicio ($fecha) {
        return $this->fecha_inicio=$fecha;
    }
    public function setFechaFin ($fecha) {
        return $this->fecha_fin=$fecha;
    }

}

?>