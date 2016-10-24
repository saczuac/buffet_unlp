<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Cuotas;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Class Resource
 * @package App
 */
class CuotasResource extends AbstractResource
{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $cuotas = $this->getEntityManager()->getRepository('App\Entity\Cuotas')->findAll();
            $data = $cuotas;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\Cuotas', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

    // POST, PUT, DELETE methods...

    public function Nuevo ($anio,$mes,$numero,$monto,$tipo,$comco){ 
        $cuota = new Cuotas();
        $cuota->setNumero($numero);
        $cuota->setAnio($anio);
        $cuota->setMes($mes);
        $cuota->setMonto($monto);
        $cuota->setTipo($tipo);
        $cuota->setComisionCobrador($comco);
        return $cuota;
        
    }
    public function insert($anio,$mes,$numero,$monto,$tipo,$comco){
        $this->getEntityManager()->persist($this->Nuevo($anio,$mes,$numero,$monto,$tipo,$comco));
        $this->getEntityManager()->flush();
        return $this->get();

}
    public function edit($id,$numero,$monto,$tipo,$comco)
    {
        $cuota = $this->getEntityManager()->getReference('App\Entity\Cuotas', $id);
        $cuota->setMonto($monto);
        $cuota->setNumero($numero);
        $cuota->setTipo($tipo);
        $cuota->setComisionCobrador($comco);
        $this->getEntityManager()->persist($cuota);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function delete($id)
    {
        $cuota = $this->getEntityManager()->getReference('App\Entity\Cuotas', $id);
        $this->getEntityManager()->remove($cuota);
        $this->getEntityManager()->flush();
        return $this->get();
    }
}

 ?>