<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Proyecto;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
/**
 * Class Resource
 * @package App
 */
class ProyectoResource extends AbstractResource
{
	public function get($id = null)
    {
        if ($id === null) {
            $alumnos = $this->getEntityManager()->getRepository('App\Entity\Proyecto')->findAll();
        } else {
            $alumnos = $this->getEntityManager()->find('App\Entity\Proyecto', $id);
        }

        return $alumnos;
    }

    /*
     * Retorna un arreglo con las entidades correspondientes
     * al arreglo de ids pasado como parámetro.
     *
     * @author: Santiago José Figueiras
     */

    public function Nuevo ($cli,$pro,$desc){
        $clienteResource = new ClienteResource();
        $cliente = $clienteResource->get($cli);
        $proyecto = new Proyecto();
        $proyecto->setCliente($cliente);
        $proyecto->setNombreProyecto($pro);
        $proyecto->setDescripcion($desc);
        return $proyecto;        
    }
    public function insert($cli,$pro,$desc){
        $this->getEntityManager()->persist($this->Nuevo($cli,$pro,$desc));
        try {
        $this->getEntityManager()->flush();
                            } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;

}
    public function Edit ($id,$cli,$pro,$desc){
        $proyecto = $this->getEntityManager()->find('App\Entity\Proyecto', $id);
        $proyecto->setNombreProyecto($pro);
        $proyecto->setDescripcion($desc);
           try {
            $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;
    }


       public function delete($id)
    {
            $proyecto = $this->getEntityManager()->find('App\Entity\Cliente', $id);
            $this->getEntityManager()->remove($proyecto);
            if ($proyecto->getTarea()->isEmpty()) {
                                      try {
                $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;
            }
            return false;
    }      
    
}

 ?>