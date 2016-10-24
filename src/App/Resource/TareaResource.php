<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Tarea;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use App\Resource\ClienteResource;
use App\Resource\ProyectoResource;
use App\Resource\ItemResource;
use App\Resource\UserResource;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * Class Resource
 * @package App
 */
class TareaResource extends AbstractResource
{
    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $cuotas = $this->getEntityManager()->getRepository('App\Entity\Tarea')->findAll();
            $data = $cuotas;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\Tarea', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

//*********************************************************************************
    public function edit($id,$cli,$pro,$desc,$ite,$horas,$dir,$tar)
    {
        $tarea = $this->getEntityManager()->getReference('App\Entity\Tarea', $id);
        $tarea->setDescripcion($desc);
        $tarea->setHorasEstimadas($horas);
        $tarea->setDireccion($dir);
        $tarea->setNombreTarea($tar);
        $this->getEntityManager()->persist($tarea);
        $this->getEntityManager()->flush();
        return $this->get();
    }

//*********************************************************************************
        public function Nuevo ($cli,$pro,$desc,$ite,$horas,$dir,$tar){
        $clienteResource = new ClienteResource();
        $cliente = $clienteResource->get($cli);
        $proyectoResource = new ProyectoResource();
        $proyecto = $proyectoResource->get($pro);
        $itemResource = new ItemResource();
        $item = $itemResource->get($ite);
        $tarea = new Tarea();
        $tarea->setCliente($cliente);
        $tarea->setProyecto($proyecto);
        $tarea->setItem($item);
        $tarea->setDescripcion($desc);
        $tarea->setHorasEstimadas($horas);
        $tarea->setDireccion($dir);
        $tarea->setNombreTarea($tar);
        return $tarea;        
    }

//*********************************************************************************
    public function insert($cli,$pro,$desc,$ite,$horas,$dir,$tar){
        $this->getEntityManager()->persist($this->Nuevo($cli,$pro,$desc,$ite,$horas,$dir,$tar));
        try{
        $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;
}

//*********************************************************************************
    

//*********************************************************************************
     public function assign($id_user, $id_tarea) {
        
        $userResource = new UserResource;
        
        $tarea = $this->get($id_tarea);

        $user = $userResource->get($id_user);


        $tarea->addUsuario($user);
        $user->addTarea($tarea);

        try {
            $userResource->getEntityManager()->persist($user);
            //$alumnoResource->getEntityManager()->flush();
            $this->getEntityManager()->persist($tarea);
            $this->getEntityManager()->flush();
        }
        catch(Exception $e){
            return array('exception' => $e);
        }
        return $responsable;
    }

//*********************************************************************************
     public function desassign($id_user, $id_tarea) {
        
        $userResource = new UserResource;
        
        $tarea = $this->get($id_tarea);

        $user = $userResource->get($id_user);


        $tarea->removeUsuario($user);
        $user->removeTarea($tarea);

        try {
            $userResource->getEntityManager()->persist($user);
            //$alumnoResource->getEntityManager()->flush();
            $this->getEntityManager()->persist($tarea);
            $this->getEntityManager()->flush();
        }
        catch(Exception $e){
            return array('exception' => $e);
        }
        return $responsable;
    }
//*********************************************************************************
    public function noAsignados($id) {

        $query_string = "
            SELECT c FROM App\Entity\User c
            WHERE c.id NOT IN (
                SELECT (ta.user) 
                FROM App\Entity\Tarea_user ta
                WHERE ta.tarea = :id)";

        $query = $this->getEntityManager()->createQuery($query_string);
        
        $query->setParameter('id', $id);

        return $query->getResult();
    }

//*********************************************************************************

    public function HorasTotales($id) {

        $query_string = "
            SELECT c.id as id,c.nombreTarea as nombre, c.descripcion as descripcion, SUM(h.horas) as ht FROM App\Entity\Tarea c JOIN App\Entity\Hora h 
            WHERE c.id = :id";

        $query = $this->getEntityManager()->createQuery($query_string);
        
        $query->setParameter('id', $id);

        return $query->getResult();
    }
//*********************************************************************************
    public function Horas($id) {

        $query_string = "
            SELECT h.id as id,u.username as nombre, c.descripcion as descripcion, SUM(h.horas) as ht FROM App\Entity\Tarea c JOIN App\Entity\Hora h JOIN App\Entity\User u   
            WHERE c.id = :id";

        $query = $this->getEntityManager()->createQuery($query_string);
        
        $query->setParameter('id', $id);

        return $query->getResult();
    }
} 

 ?>