<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

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
     * @Column(name="id_alumno", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
	protected $id_alumno;

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
     * @var date
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
	protected $direccion;

	/**
     * @var date
     * @Column(type="date")
     */
	protected $fecha_ingreso;

	/**
     * @var date
     * @Column(type="date", nullable=true)
     */
	protected $fecha_egreso;

	/**
     * @var date
     * @Column(type="date")
     */
	protected $fecha_alta;

     public function getId() {
          return $this->id_alumno;
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

     public function getDireccion() {
          return $this->direccion;
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


}



 ?>