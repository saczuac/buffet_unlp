<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="cuota")
 *
 */

class Cuotas
{
	/**
     * @var integer
     *
     * @Id
     * @Column(name="idCuota", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
	protected $idCuota;

     /**
     * @OneToMany(targetEntity="Pago", mappedBy="cuota")
     **/
     protected $pagos;

	/**
     * @var integer
     * @Column(type="integer", length=4)
     */
	protected $anio;

	/**
     * @var integer
     * @Column(type="integer", length=2)
     */
	protected $mes;

	/**
     * @var integer
     * @Column(type="integer", length=16)
     */
	protected $numero;

	/**
     * @var integer
     * @Column(type="integer", length=16)
     */
	protected $monto;

	/**
     * @var string
     * @Column(type="string")
     */
	protected $tipo;

	/**
     * @var integer
     * @Column(type="integer")
     */
	protected $comisionCobrador;

     /**
     * @var date
     * @Column(type="date")
     */
     protected $fechaAlta;
     
     public function getId() {
          return $this->idCuota;
     }

     public function getAnio() {
          return $this->anio;
     }

     public function getMes() {
          return $this->mes;
     }

     public function getNumero() {
          return $this->numero;
     }


     public function getMonto() {
          return $this->monto;
     }

     public function getTipo() {
          return $this->tipo;
     }

     public function getComisionCobrador() {
          return $this->comisionCobrador;
     }

     public function getFechaAlta() {
          return $this->fechaAlta;
     }
     public function setId($id) {
          $this->idCuota = $id;

     return $this;
     }

     public function setAnio($anio) {
          $this->anio = $anio;
          return $this;
     }

     public function setMes($mes) {
          $this->mes = $mes;
          return $this;
     }

     public function setNumero($numero) {
          $this->numero = $numero;
          return $this;
     }


     public function setMonto($monto) {
          $this->monto = $monto;
          return $this;
     }

     public function setTipo($tipo) {
          $this->tipo = $tipo;
          return $this;
     }

     public function setComisionCobrador($cc) {
          $this->comisionCobrador = $cc;
          return $this;
     }

     public function setFechaAlta($fechaAlta) {
          $this->fechaAlta = $fechaAlta;
          return $this;
     }



}



 ?>