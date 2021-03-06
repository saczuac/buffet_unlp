<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="rol")
 */
class Rol
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
     * @Column(type="string", length=45)
     */
    protected $nombre;

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
}

?>
