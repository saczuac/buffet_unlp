<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="responsable")
 */
class Responsable {
	/**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToMany(targetEntity="Alumno", mappedBy="responsables", cascade={"persist"})
     **/
    protected $alumnos;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
    }

    /**
     * @var string
     * @Column(type="string", length=25)
     */
	protected $tipo;

	/**
     * @JoinColumn(name="id_usuario", referencedColumnName="id")
     **/
	protected $nombre_usuario;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $nombre;

    /**
     * @var string
     * @Column(type="string", length=45)
     */
	protected $apellido;

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
     * @var string
     * @Column(type="string", length=45)
     */
	protected $mail;

	/**
     * @var integer
     * @Column(type="integer", length=45)
     */
	protected $telefono;

	// TODO: definir getters y setters

    public function getId () {
        return $this->id;
    }

    public function getTipo () {
        return $this->tipo;
    }

    public function getNombre () {
        return $this->nombre;
    }

    public function getApellido () {
        return $this->apellido;
    }

    public function getFechaNacimiento () {
        return $this->fecha_nacimiento;
    }

    public function getSexo () {
        return $this->sexo;
    }

    public function getAlumnos() {
        return $this->alumnos;
    }

    public function getEmail() {
        return $this->mail;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function addAlumno(Alumno $alumno) {
          $this->alumnos->add($alumno);
          return $this;
     }

    public function setTipo ($tipo) {
        return $this->tipo = $tipo;
    }

    public function setNombre ($nombre) {
        return $this->nombre = $nombre;
    }

    public function setApellido ($apellido) {
        return $this->apellido = $apellido;
    }

    public function setFechaNacimiento ($fecha_nacimiento) {
        return $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function setSexo ($sexo) {
        return $this->sexo = $sexo;
    }

    public function setEmail($email) {
        return $this->mail = $email;
    }

    public function setDireccion($direccion) {
        return $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        return $this->telefono = $telefono;
    }

    public function removeAlumno($alumno) {
        return $this->getAlumnos()->removeElement($alumno);
    }
}

?>