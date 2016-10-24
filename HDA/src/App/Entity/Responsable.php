<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

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
     * @Column(name="id_responsable", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id_responsable;

    /**
     * @var string
     * @Column(type="string", length=25)
     */
	protected $tipo;

	/**
     * @OneToOne(targetEntity="User", inversedBy="nombre")
     * @JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
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
}

?>