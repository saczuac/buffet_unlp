<?php
namespace Model\Entity;


use Model\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="v_balance")
 */
class Balance
{
    /**
     * @var Date
     *
     * @Id
     * @Column(type="date")
     */
    protected $fecha;
    /**
     * @Column(type="integer")
     * @var Integer
     */
    protected $ingreso;

    /**
     * Gets the value of ingreso.
     *
     * @return Integer
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Sets the value of ingreso.
     *
     * @param Integer $ingreso the ingreso
     *
     * @return self
     */
    public function setIngreso(Integer $ingreso)
    {
        $this->ingreso = $ingreso;

        return $this;
    }

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
}
 ?>
