<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @ORM\HasLifecycleCallbacks
 * @Table(name="pago")
 *
 */

class Pago
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
     * @ManyToOne(targetEntity="Alumno", inversedBy="pagos", cascade={"remove", "merge"})
     * @JoinColumn(name="id_alumno", referencedColumnName="id")
     **/
	protected $alumno;

	/**
     * @ManyToOne(targetEntity="Cuotas", inversedBy="pagos", cascade={"remove", "merge"})
     * @JoinColumn(name="id_cuota", referencedColumnName="idCuota")
     **/
	protected $cuota;

	/**
     * @var boolean
     * @Column(type="boolean")
     */
	protected $becado;

	/**
     * @var date
     * @Column(type="date")
     */
	protected $fecha_alta;

	/**
	 *
     * @var date
     * @Column(type="date")
     */
	protected $fecha_actualizado;

	/**
     * @var string
     * @Column(type="string")
     */
	protected $cobrador;


	public function getId() {
		return $this->id;
	}

	public function getAlumno() {
		return $this->alumno;
	}

	public function getCuota() {
		return $this->cuota;
	}

	public function getFecha() {
		return $this->fecha;
	}

	public function getBecado() {
		return $this->becado;
	}

	public function getFechaAlta() {
		return $this->fecha_alta;
	}

	public function getFechaActualizado() {
		return $this->fecha_actualizado;
	}
	public function getCobrador() {
		return $this->cobrador;
	}
	public function setAlumno($alumno) {
		$this->alumno = $alumno;
	}

	public function setCuota($cuota) {
		$this->cuota = $cuota;
	}

	public function setBecado($becado) {
		$this->becado = $becado;
	}

	public function setFechaAlta($fecha_alta) {
		$this->fecha_alta = $fecha_alta;
	}

	public function setFechaActualizado() {
		$this->fecha_actualizado = new \DateTime();
	}
	public function setCobrador($cobrador) {
		$this->cobrador = $cobrador;
	}

	/*
	 * @PrePersist()
	 * @PreUpdate()
	 */
	public function updateModifiedDate() {
		$this->fecha_actualizado = new \DateTime();
	}


}