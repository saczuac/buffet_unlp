<?php
namespace Model\Entity;


use Model\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="venta_productos")
 */
class VentaProductos
{
    /**
     * @var Date
     *
     * @Id
     * @Column(type="date")
     */
    protected $fecha;
    /**
     * @ManyToOne(targetEntity="Producto", inversedBy="egreso_detalle")
     * @JoinColumn(name="producto", referencedColumnName="id")
     */
    protected $producto;
    /**
    * @Column(type="integer")
    * @var integer
    */
    protected $cantidad;
    /**
     * Gets the value of fecha.
     *
     * @return Date
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Sets the value of fecha.
     *
     * @param Date $fecha the fecha
     *
     * @return self
     */
    public function setFecha(Date $fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Gets the value of producto.
     *
     * @return mixed
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Sets the value of producto.
     *
     * @param mixed $producto the producto
     *
     * @return self
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Gets the value of cantidad.
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Sets the value of cantidad.
     *
     * @param integer $cantidad the cantidad
     *
     * @return self
     */
    protected function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }
}
 ?>
