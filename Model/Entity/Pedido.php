<?php
namespace Model\Entity;


use Model\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;
use Model\Resource\EstadoResource;
/**
 *
 * @Entity
 * @Table(name="pedido")
 */
class Pedido
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
     * @ManyToOne(targetEntity="Estado", inversedBy="pedidos")
     * @JoinColumn(name="estado_id", referencedColumnName="id")
     */
    protected $estado_id;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha_alta;
    /**
     * @ManyToOne(targetEntity="Usuario", inversedBy="pedidos")
     * @JoinColumn(name="usuario_id", referencedColumnName="id")
     */
     protected $usuario_id;
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $observacion;
    /**
     * @OneToMany(targetEntity="PedidoDetalle", mappedBy="pedido_id")
     **/
    protected $detalles;
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $comentario;
    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

    public function getId() {
    	return $this->id;
    }
    public function getEstado_Id() {
      return $this->estado_id;
    }
    public function getFecha_Alta() {
    	return $this->fecha_alta;
    }
    public function getUsuario_Id() {
        return $this->usuario_id;
    }
    public function getObservacion() {
        return $this->observacion;
    }
    public function getDetalles()
    {
        return $this->detalles;
    }
    public function setEstado_Id($id) {
        $this->estado_id = $id;
    }
    public function setFecha_Alta($fecha) {
        $this->fecha_alta = $fecha;
    }
    public function setUsuario_Id($id) {
        $this->usuario_id = $id;
    }
    public function setObservacion($obs) {
        $this->observacion = $obs;
    }
  
    public function getComentario()
    {
        return $this->comentario;
    }

    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }
    public function cancelar($estadoCerrado,$comentario) {
        $this->setComentario($comentario);
        $this->setEstado_Id($estadoCerrado);
    }
    public function pendiente()
    {
        return ($this->estado_id==EstadoResource::getInstance()->get(1));
    }
}
 ?>
