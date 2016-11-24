<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="pedido_detalle")
 */
class PedidoDetalle
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
     * @ManyToOne(targetEntity="Pedido", inversedBy="detalles")
     * @JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    protected $pedido_id;
    /**
     * @ManyToOne(targetEntity="Producto", inversedBy="detalles_prod")
     * @JoinColumn(name="producto_id", referencedColumnName="id")
     */
     protected $producto_id;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $cantidad;

    public function getId() {
    	return $this->id;
    }
    public function getPedido_Id() {
      return $this->pedido_id;
    }
    public function getCantidad() {
    	return $this->cantidad;
    }
    public function getProducto_Id() {
        return $this->producto_id;
    }
    public function setPedido_Id($id) {
        $this->pedido_id = $id;
    }
    public function setCantidad($cant) {
        $this->cantidad = $cant;
    }
    public function setProducto_Id($id) {
        $this->producto_id = $id;
    }
}
 ?>
