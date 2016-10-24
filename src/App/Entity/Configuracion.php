<?php
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="configuracion")
 */
class Configuracion
{
    /**
     * @var id
     *
     * @Id
     * @Column(name="id")
     */
    protected $id;
    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $titulo;
    /**
     * @var string
     * @Column(type="string", length=1024)
     */
    protected $contenido;
    /**
     * @var string
     * @Column(type="string", length=128)
     */
    protected $email;
    /**
     * @var integer
     * @Column(type="integer", length=1)
     */
    protected $habilitado;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $paginado;

    // Define setters/getters for all properties...

    public function getId() {
    	return $this->id;
    }
    public function getTitulo() {
    	return $this->titulo;
    }
    public function getContenido() {
        return $this->contenido;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getHabilitado() {
        return $this->habilitado;
    } 
    public function getPaginado() {
        return $this->paginado;
    }    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
        return $this;  
    }
    public function setContenido($contenido) {
        $this->contenido = $contenido;
        return $this; 
    }
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
        return $this;
    }
    public function setPaginado($paginado) {
        $this->paginado = $paginado;
        return $this;
    }
}

 ?>