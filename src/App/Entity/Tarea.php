<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="tarea")
 */
class Tarea {
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
     * @ManyToOne(targetEntity="Item", inversedBy="tarea", cascade={"merge"})
     * @JoinColumn(name="item_id", referencedColumnName="id")
     **/
    protected $item;

    /**
     * @ManyToMany(targetEntity="User", inversedBy="tareas", cascade={"merge"})
     * @JoinTable(name="tarea_user")
     **/
     protected $usuarios;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $horasEstimadas;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $descripcion;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $nombreTarea;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $direccion;

     public function __construct()
     {
          $this->usuarios = new ArrayCollection();
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
    public function getUsuarios () {
        return $this->usuarios;
    }
    public function getItem () {
        return $this->item;
    }
    public function getDescripcion() {
          return $this->descripcion;
    }

    public function getNombreTarea () {
        return $this->nombreTarea;
    }

    public function getHorasEstimadas () {
        return $this->horasEstimadas;
    }
    public function getDireccion () {
        return $this->direccion;
    }
    public function setCliente ($idCliente) {
        return $this->cliente=$idCliente;
    }
    public function setProyecto ($idProyecto) {
        return $this->proyecto=$idProyecto;
    }
    public function setItem ($idItem) {
        return $this->item=$idItem;
    }

    public function setNombreTarea ($nombreTarea) {
        return $this->nombreTarea = $nombreTarea;
    }

     public function setDescripcion($descripcion) {
          $this->descripcion = $descripcion;
          return $this;
     }
     public function setHorasEstimadas ($horasEstimadas) {
        return $this->horasEstimadas = $horasEstimadas;
    }
    public function setDireccion ($direccion) {
        return $this->direccion = $direccion;
    }
    public function addUsuario (User $usuario) {
          $this->usuarios->add($usuario);
          return $this;
    }
    public function removeUsuario($usuario) {
        return $this->getUsuarios()->removeElement($usuario);
    }

}

?>