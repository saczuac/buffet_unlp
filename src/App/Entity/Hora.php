<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="horas")
 */ 
class Hora {
	/**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @ManyToOne(targetEntity="User", inversedBy="horas")
     * @JoinColumn(name="idUser", referencedColumnName="id")
     */
    protected $usuario;
    /**
     * @ManyToOne(targetEntity="Cliente", cascade={"merge"})
     * @JoinColumn(name="cliente_id", referencedColumnName="id")
     **/
    protected $cliente;
     /**
     * @ManyToOne(targetEntity="Proyecto", cascade={"merge"})
     * @JoinColumn(name="proyecto_id", referencedColumnName="id")
     **/
    protected $proyecto;
     /**
     * @ManyToOne(targetEntity="Item", cascade={"merge"})
     * @JoinColumn(name="item_id", referencedColumnName="id")
     **/
    protected $item;
     /**
     * @ManyToOne(targetEntity="Tarea", cascade={"merge"})
     * @JoinColumn(name="tarea_id", referencedColumnName="id")
     **/
    protected $tarea;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $horas;


    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $descripcion;

    /**
     * @var date
     * @Column(type="date")
     */
    protected $fecha;


    public function getId () {
        return $this->id;
    }
    public function getUsuario () {
        return $this->usuario;
    }
    public function getCliente () {
        return $this->cliente;
    }
    public function getProyecto () {
        return $this->proyecto;
    }
    public function getItem () {
        return $this->item;
    }
    public function getTarea () {
        return $this->tarea;
    }

    public function getDescripcion() {
          return $this->descripcion;
     }
     public function getHoras() {
      return $this->horas;
 }

    public function getFecha () {
        return $this->fecha;
    }

    public function setUsuario ($usuario) {
        return $this->usuario=$usuario;
    }
    public function setCliente ($idCliente) {
        return $this->cliente=$idCliente;
    }
    public function setProyecto ($idProyecto) {
        return $this->proyecto=$idProyecto;
    }

    public function setDescripcion($descripcion) {
          return $this->descripcion=$descripcion;
     }
     public function setTarea($tarea) {
      return $this->tarea=$tarea;
    }
         public function setItem($item) {
      return $this->item=$item;
    }
     public function setHoras($horas) {
      return $this->horas=$horas;
    }

    public function setFecha ($fecha) {
        return $this->fecha=$fecha;
    }
}

?>