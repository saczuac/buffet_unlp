<?php
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="usuario")
 */
class User
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="idUsuario", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $idUsuario;
    /**
     * @var string
     * @Column(type="string", length=16)
     */
    protected $username;
    /**
     * @var string
     * @Column(type="integer", length=16)
     */
    protected $password;
    /**
     * @var integer
     * @Column(type="integer")
     */

    protected $idRol;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email;

    // Define setters/getters for all properties...

    public function getId() {
    	return $this->idUsuario;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getName() {
    	return $this->name;
    }

    public function setName($name) {
    	$this->name = $name;

    	return $this;
    }

    public function getEmail() {
    	return $this->email;
    }
     public function getPass() {
        return $this->password;
    }

    public function setEmail($email) {
    	$this->email = $email;

    	return $this;
    }
}

 ?>