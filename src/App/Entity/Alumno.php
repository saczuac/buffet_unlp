<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="alumno")
 *
 */
class Alumno
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
     * @ManyToMany(targetEntity="Responsable", inversedBy="alumnos", cascade={"merge"})
     * @JoinTable(name="alumno_responsable")
     **/
     protected $responsables;

     /**
     * @OneToMany(targetEntity="Pago", mappedBy="alumno", cascade={"merge"})
     **/
     protected $pagos;

	/**
     * @var string
     * @Column(type="string", length=8)
     */
	protected $tipo_documento;

	/**
     * @var integer
     * @Column(type="integer", length=11)
     */
	protected $numero_documento;

	/**
     * @var string
     * @Column(type="string", length=45)
     */
	protected $apellido;

	/**
     * @var string
     * @Column(type="string", length=45)
     */
	protected $nombre;

	/**
     * @var \DateTime
     * @Column(type="date")
     */
	protected $fecha_nacimiento;

	/**
     * @var string
     * @Column(type="string", length=45)
     */
	protected $sexo;

	/**
     * @var string
     * @Column(type="string", length=50)
     */
	protected $calle;

     /**
     * @var string
     * @Column(type="string", length=50)
     */
     protected $numero;

     /**
     * @var string
     * @Column(type="string", length=25)
     */
     protected $longitud;

     /**
     * @var string
     * @Column(type="string", length=25)
     */
     protected $latitud;

     /**
     * @var string
     * @Column(type="string", length=100)
     */
     protected $email;

	/**
     * @var \DateTime
     * @Column(type="date")
     */
	protected $fecha_ingreso;

	/**
     * @var \DateTime
     * @Column(type="date", nullable=true)
     */
	protected $fecha_egreso;

	/**
     * @var \DateTime
     * @Column(type="date")
     */
	protected $fecha_alta;

     public function __construct()
     {
          $this->responsables = new ArrayCollection();
          $this->pagos = new ArrayCollection();
     }

     public function getId() {
          return $this->id;
     }

     public function getTipoDocumento() {
          return $this->tipo_documento;
     }

     public function getNumeroDocumento() {
          return $this->numero_documento;
     }

     public function getApellido() {
          return $this->apellido;
     }

     public function getNombre() {
          return $this->nombre;
     }

     public function getFechaNacimiento() {
          return $this->fecha_nacimiento;
     }

     public function getSexo() {
          return $this->sexo;
     }

     public function getCalle() {
          return $this->calle;
     }

     public function getNumero() {
          return $this->numero;
     }

     public function getFechaIngreso() {
          return $this->fecha_ingreso;
     }

     public function getFechaEgreso() {
          return $this->fecha_egreso;
     }

     public function getFechaAlta() {
          return $this->fecha_alta;
     }

     public function getResponsables() {
          return $this->responsables;
     }

     public function getEmail() {
          return $this->email;
     }

     public function getCantidadResponsables() {
          return $this->getResponsables()->count();
     }

     public function getPagos() {
          return $this->pagos;
     }

     public function getLongitud() {
          return $this->longitud;
     }

     public function getLatitud() {
          return $this->latitud;
     }

     public function addResponsable($responsable) {
          $this->getResponsables()->add($responsable);
          return $this;
     }

     public function setTipoDocumento($tipo_documento) {
          $this->tipo_documento = $tipo_documento;
          return $this;
     }

     public function setNumeroDocumento($numero_documento) {
          $this->numero_documento = $numero_documento;
          return $this;
     }

     public function setApellido($apellido){
          $this->apellido = $apellido;
          return $this;
     }

     public function setNombre($nombre) {
          $this->nombre = $nombre;
          return $this;
     }

     public function setFechaNacimiento($fecha_nacimiento) {
          $this->fecha_nacimiento = $fecha_nacimiento;
          return $fecha_nacimiento;
     }

     public function setSexo($sexo) {
          $this->sexo = $sexo;
          return $this;
     }

     public function setCalle($calle) {
          $this->calle = $calle;
          return $this;
     }

     public function setNumero($numero) {
          return $this->numero = $numero;
     }

     public function setFechaIngreso($fecha_ingreso) {
          $this->fecha_ingreso = $fecha_ingreso;
          return $this;
     }

     public function setFechaEgreso($fecha_egreso) {
          $this->fecha_egreso = $fecha_egreso;
          return $this;
     }

     public function setFechaAlta($fecha_alta) {
          $this->fecha_alta = $fecha_alta;
          return $this;
     }

     public function setEmail($email) {
          $this->email = $email;
          return $this;
     }

     public function setLongitud($longitud) {
          $this->longitud = $longitud;
     }

     public function setLatitud($latitud) {
          $this->latitud = $latitud;
     }

     public function removeResponsable($responsable) {
          return $this->getResponsables()
               ->removeElement($responsable);
     }


}



 ?>