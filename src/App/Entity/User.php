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
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
   /** 
     * @var string
     * @Column(type="string", length=16)
     */
    protected $password;
   /** 
     * @var string
     * @Column(type="string", length=32)
     */
    protected $username;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $idRol;
    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $habilitado;
    /**
     * @ManyToMany(targetEntity="Tarea", mappedBy="usuarios", cascade={"persist"})
     **/
    protected $tareas;
    /**
     * @OneToMany(targetEntity="Hora", mappedBy="usuario")
     **/
    protected $horas;
    
    public function __construct()
    {
        $this->tareas = new ArrayCollection();
        $this->horas = new ArrayCollection();
    }

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
    protected $nameRol;
    // Define setters/getters for all properties...

    public function getId() {
    	return $this->id;
    }
    public function getTareas() {
        return $this->tareas;
    }
    public function getUsername() {
    	return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getIdRol() {
        return $this->idRol;
    }
    public function getHabilitado() {
        return $this->habilitado;
    }    
    public function getHoras() {
        return $this->horas;
    }    
    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getNameRol() {
        $aux='';
        switch ($this->idRol) {
           case 1:
                 $aux='consultor';
                 break;
           case 2:
                 $aux='lider';
                 break;
            case 3:
                 $aux='gerente';
                 break;
        }   
        return $aux;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function setUsername($username) {
        $this->id = $username;
        return $this;  
    }
    public function setPassword($password) {
        $this->password = $password;
        return $this; 
    }
    public function setRol($rol) {
        $this->idRol = $rol;
        return $this;
    }
    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
        return $this;
    }
    public function setName($name) {
    	$this->name = $name;
    	return $this;
    }
    public function setEmail($email) {
    	$this->email = $email;
    	return $this;
    }
    public function addTarea(Tarea $tarea) {
          $this->tareas->add($tarea);
          return $this;
    }
    public function removeTarea($tarea) {
        return $this->getTareas()->removeElement($tarea);
    }



}

 ?>