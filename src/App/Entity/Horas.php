<?php
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use App\Entity\Cliente;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
/**
 *
 * @Entity
 * @Table(name="horas")
 */
class Horas
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="idHora", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $idHora;
     // ...
    /**
     * @var string
     * @Column(type="string", length=128)
     */
    protected $idCliente;
    /**
     * @var string
     * @Column(type="string", length=128)
     */
    protected $idProyecto;
    /**
     * @var string
     * @Column(type="string", length=128)
     */
    protected $usuario;
    /**
     * @var string
     * @Column(type="string", length=128)
     */
    protected $tarea;
    /**
     * @var string
     * @Column(type="string", length=1024)
     */
    protected $descripcion;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $cantidad_horas;
    // Define setters/getters for all properties...

    public function getId() {
        return $this->idHora;
    }
    public function getIdHora() {
        return $this->idHora;
    }
    public function getIdCliente() {
        return $this->idCliente;
    }
    public function getIdProyecto() {
        return $this->idProyecto;
    }
    public function getUsuario() {
        return $this->usuario;
    }
    public function getTarea() {
        return $this->tarea;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function getCantidad_horas() {
        return $this->cantidad_horas;
    }

    public function setId($idHora) {
        $this->idHora = $idHora;
    }
    public function setIdHora($idHora) {
        $this->idHora = $idHora;
    }
    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }
    public function setIdProyecto($idRol) {
        $this->idProyecto = $idProyecto;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    public function setTarea($tarea) {
        $this->tarea = $tarea;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function setCantidad_horas($cantidad_horas) {
        $this->cantidad_horas = $cantidad_horas;
    }

}

 ?>