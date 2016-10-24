<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Parrafo;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Class Resource
 * @package App
 */
class ParrafoResource extends AbstractResource
{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $conf = $this->getEntityManager()->getRepository('App\Entity\Parrafo')->findAll();
            $data = $conf;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\Parrafo', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

    // POST, PUT, DELETE methods...

   public function Nuevo ($parrafo){ 
        $cuota = new Parrafo();
        $cuota->setParrafo($parrafo);
        
        return $cuota;
        
    }
    public function insert($parrafo){
        $this->getEntityManager()->persist($this->Nuevo($parrafo));
        $this->getEntityManager()->flush();
        return $this->get();

}
    public function edit($id,$parrafo)
    {
        $conf = $this->getEntityManager()->find('App\Entity\Parrafo', $id);
        $conf->setParrafo($parrafo);
        $this->getEntityManager()->persist($conf);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function delete($id)
    {
        $cuota = $this->getEntityManager()->find('App\Entity\Parrafo', $id);
        $this->getEntityManager()->remove($cuota);
        $this->getEntityManager()->flush();
        return $this->get();
    }

}

 ?>