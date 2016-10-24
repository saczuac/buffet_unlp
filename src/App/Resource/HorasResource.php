<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Horas;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Class Resource
 * @package App
 */
class HorasResource extends AbstractResource
{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $horas = $this->getEntityManager()->getRepository('App\Entity\Horas')->findAll();
            $data = $horas;}
         else {
            $horas = $this->getEntityManager()->find('App\Entity\Horas', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }


}

 ?>