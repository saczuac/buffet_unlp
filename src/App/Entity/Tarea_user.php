<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="tarea_user")
 */
class Tarea_user {
    /**
         * @Id
     * @OneToOne(targetEntity="Tarea")
     * @JoinColumn(name="tarea_id", referencedColumnName="id")
     */
    protected $tarea;
    /**
         * @Id
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    

    public function getTarea () {
        return $this->tarea;
    }
    public function getUser () {
        return $this->user;
    }
    
    public function setTarea ($tarea) {
        return $this->tarea=$tarea;
    }
    public function setUser ($user) {
        return $this->user=$user;
    }
   

}

?>