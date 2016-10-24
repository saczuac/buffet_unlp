<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Item;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use App\Resource\ClienteResource;
use App\Resource\ProyectoResource;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
/**
 * Class Resource
 * @package App
 */
class ItemResource extends AbstractResource
{
    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $cuotas = $this->getEntityManager()->getRepository('App\Entity\Item')->findAll();
            $data = $cuotas;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\Item', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }
    public function Nuevo ($cli,$pro,$desc,$itemn,$fechaInicio,$fechaFin){
        $clienteResource = new ClienteResource();
        $cliente = $clienteResource->get($cli);
        $proyectoResource = new ProyectoResource();
        $proyecto = $proyectoResource->get($pro);
        $item = new Item();
        $item->setCliente($cliente);
        $item->setProyecto($proyecto);
        $item->setDescripcion($desc);
        $item->setNombreItem($itemn);
        $item->setFechaInicio(new \DateTime($fechaInicio));
        $item->setFechaFin(new \DateTime($fechaFin));
        return $item;        
    }
    public function insert($cli,$pro,$desc,$itemn,$fechaInicio,$fechaFin){
        $this->getEntityManager()->persist($this->Nuevo($cli,$pro,$desc,$itemn,$fechaInicio,$fechaFin));
        try{
        $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;

}
    public function Edit ($id,$cli,$pro,$desc,$itemn,$fechaInicio,$fechaFin){
        $item = $this->getEntityManager()->find('App\Entity\Item', $id);
        $item->setDescripcion($desc);
        $item->setNombreItem($itemn);
        $item->setFechaInicio(new \DateTime($fechaInicio));
        $item->setFechaFin(new \DateTime($fechaFin));
           try {
            $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;
    } 

   
}

 ?>