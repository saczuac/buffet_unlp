<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Hora;
use App\Resource\ClienteResource;
use App\Resource\ProyectoResource;
use App\Resource\ItemResource;
use App\Resource\UserResource;
use App\Resource\TareaResource;

/**
 * Class Resource
 * @package App
 */
class HoraResource extends AbstractResource
{
	public function get($id = null)
    {
        if ($id === null) {
            $hora = $this->getEntityManager()->getRepository('App\Entity\Hora')->findAll();
        } else {
            $hora = $this->getEntityManager()->find('App\Entity\Hora', $id);
        }

        return $hora;
    }

    /*
     * Retorna un arreglo con las entidades correspondientes
     * al arreglo de ids pasado como parámetro.
     *
     * @author: Santiago José Figueiras
     */

        public function Nuevo ($user,$cli,$it,$pro,$desc,$horas,$fecha,$tar){
        $clienteResource = new ClienteResource();
        $cliente = $clienteResource->get($cli);

        $proyectoResource = new ProyectoResource();
        $proyecto = $proyectoResource->get($pro);

        $itemResource = new ItemResource();
        $item = $itemResource->get($it);

        $tareaResource = new TareaResource();
        $tarea = $tareaResource->get($tar);

        $userResource = new UserResource();
        $us = $userResource->get($user);

        $hora = new Hora();
        $hora->setUsuario($us);
        $hora->setCliente($cliente);
        $hora->setProyecto($proyecto);
        $hora->setDescripcion($desc);
        $hora->setItem($item);
        $hora->setTarea($tarea);
        $hora->setHoras($horas);
        $hora->setFecha(new \DateTime($fecha));
        return $hora;        
    }
    public function insert($user,$cli,$it,$pro,$desc,$horas,$fecha,$tar){
        $this->getEntityManager()->persist($this->Nuevo($user,$cli,$it,$pro,$desc,$horas,$fecha,$tar));
        $this->getEntityManager()->flush();
        return $this->get();

    }
        public function cuotasInpagas($id) {
        $query_string = " 
            SELECT  h.descripcion as descripcion, h.horas as horas, c.nombreCliente as cliente  
            FROM App\Entity\Hora h INNER JOIN App\Entity\Cliente c 
            WHERE h.usuario = :id AND h.cliente = c.id";
            
        $query = $this->getEntityManager()->createQuery($query_string);
        
        $query->setParameter('id', $id);
        return $query->getResult();
    }
    
}

 ?>