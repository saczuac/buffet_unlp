<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Configuracion;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Class Resource
 * @package App
 */
class ConfiguracionResource extends AbstractResource
{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $conf = $this->getEntityManager()->getRepository('App\Entity\Configuracion')->findAll();
            $data = $conf;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\Configuracion', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

    // POST, PUT, DELETE methods...

/*    public function Nuevo ($anio,$mes,$numero,$monto,$tipo,$comco){ 
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
*/    public function edit($titulo,$contenido,$email,$habilitado,$paginado)
    {
        $conf = $this->getEntityManager()->getReference('App\Entity\Configuracion', '1');
        $conf->setTitulo($titulo);
        $conf->setEmail($email);
        $conf->setHabilitado($habilitado);
        $conf->setPaginado($paginado);
        $this->getEntityManager()->persist($conf);
        $this->getEntityManager()->flush();
        return $this->get();
    }
/*
    public function delete($id)
    {
        $cuota = $this->getEntityManager()->getReference('App\Entity\Cuotas', $id);
        $this->getEntityManager()->remove($cuota);
        $this->getEntityManager()->flush();
        return $this->get();
    }*/
        public function habilitar($id)
    {$data = $this->getEntityManager()->find('App\Entity\Configuracion', '1');
        $data->setHabilitado(1);
        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->flush();
        return true;
    }
    public function deshabilitar($id,$mensaje)
    {$data = $this->getEntityManager()->find('App\Entity\Configuracion', '1');
        $data->setContenido($mensaje);
        $data->setHabilitado(0);
        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->flush();
        return true;
    }
}

 ?>