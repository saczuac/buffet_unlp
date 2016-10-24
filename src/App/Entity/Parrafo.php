<?php
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="parrafo")
 */
class Parrafo{
    /**
     * @var id
     *
     * @Id
     * @Column(name="id")
       * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @Column(type="string", length=1024)
     */
    protected $parrafo;
    /**
     * @var integer
     * @Column(type="integer", length=1)
     */
    protected $b;
    /**
     * @var integer
     * @Column(type="integer", length=1)
     */
    protected $l;

    // Define setters/getters for all properties...

    public function getId() {
    	return $this->id;
    }
    public function getParrafo() {
    	return $this->parrafo;
    }
    public function getB() {
        return $this->b;
    }
    public function getL() {
        return $this->l;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function setParrafo($parrafo) {
        $this->parrafo = $parrafo;
        return $this;  
    }
    public function setB($b) {
        $this->b = $b;
        return $this; 
    }
    public function setL($l) {
        $this->l = $l;
        return $this;
    }
}

 ?>