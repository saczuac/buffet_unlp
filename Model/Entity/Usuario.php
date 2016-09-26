<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="usuario")
 */
class Usuario
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
     * @var string
     * @Column(type="string", length=16)
     */
    protected $clave;
   /**
     * @var string
     * @Column(type="string", length=32)
     */
    protected $nombre;
    /**
      * @var string
      * @Column(type="string", length=32)
      */
     protected $apellido;
    /**
      * @var string
      * @Column(type="string", length=62)
      */
     protected $username;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $rol_id;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $ubicacion_id;
    /**
     * @var integer
     * @Column(type="integer", length=8)
     */
    protected $documento;
    /**
     * @var integer
     * @Column(type="integer", length=45)
     */
    protected $telefono;
    /**
     * @OneToMany(targetEntity="pedido", mappedBy="usuario")
     **/
    protected $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email;

    public function getId() {
    	return $this->id;
    }
    public function getPedidos() {
        return $this->pedidos;
    }
    public function getUsername() {
    	return $this->username;
    }
    public function getClave() {
        return $this->clave;
    }
    public function getRol_Id() {
        return $this->rol_id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    public function setDocumento($documento) {
        $this->documento = $documento;
    }
    public function setClave($clave) {
        $this->clave = $clave;
    }
    public function setRol_Id($rol_id) {
        $this->rol_id = $rol_id;
    }
    public function setNombre($nombre) {
    	$this->nombre = $nombre;
    }
    public function setEmail($email) {
    	$this->email = $email;
    }
    public function addPedido(Pedido $pedido) {
          $this->pedido->add($pedido);
    }
    public function removePedido($pedido) {
        return $this->getPedidos()->removeElement($pedido);
    }
}
 ?>
