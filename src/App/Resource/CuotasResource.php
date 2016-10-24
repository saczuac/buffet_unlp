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
            $cuotas = $this->getEntityManager()->getRepository('App\Entity\Cuotas')->findBy(array(), array('anio' => 'ASC', 'mes' => 'ASC'));
            $data = $cuotas;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\Cuotas', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

    // POST, PUT, DELETE methods...

    public function Nuevo ($anio,$mes,$numero,$monto,$tipo,$comco){ 
        $today = new \DateTime("now");

        $cuota = new Cuotas();
        $cuota->setNumero($numero);
        $cuota->setAnio($anio);
        $cuota->setMes($mes);
        $cuota->setMonto($monto);
        $cuota->setTipo($tipo);
        $cuota->setComisionCobrador($comco);
        $cuota->setFechaAlta($today);
        return $cuota;
        
    }
    public function insert($anio,$mes,$numero,$monto,$tipo,$comco){
        $this->getEntityManager()->persist( $this->Nuevo($anio,$mes,$numero,$monto,$tipo,$comco));
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
        $cuota = $this->getEntityManager()->find('App\Entity\Cuotas', $id);
        $this->getEntityManager()->remove($cuota);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function cuotasInpagas() {
        $query_string = " 
            SELECT  c.anio, c.mes, c.tipo, c.numero, c.monto, c.comisionCobrador, c.fechaAlta,
                    a.nombre, a.apellido, a.tipo_documento, a.numero_documento, a.fecha_nacimiento,
                    a.fecha_ingreso, a.fecha_egreso, a.email
            FROM cuota c JOIN alumno a
            WHERE c.idCuota NOT IN (
                SELECT cu.idCuota
                FROM pago pa
                INNER JOIN cuota cu
                ON (pa.id_cuota = cu.idCuota)
                WHERE cu.anio <= YEAR(CURDATE()) 
                    AND cu.mes <= MONTH(CURDATE())
                )";
            
        $stmt = $this->getEntityManager()->getConnection()->prepare($query_string);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function cuotasInpagasPara($id_alumno, $anio = null) {

        $query_string = "
            SELECT c 
            FROM App\Entity\Cuotas c 
            WHERE c.idCuota NOT IN (
                SELECT IDENTITY(p.cuota) 
                FROM App\Entity\Pago p 
                WHERE p.alumno = :alumno)";

        if($anio != null)
            $query_string .= " and c.anio = :anio";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('alumno', $id_alumno);

        if($anio != null)
            $query->setParameter('anio', $anio);

        return $query->getResult();
    }

    public function cuotasPagas($id_alumno = null, $anio = null) {
        $query_string = "
            SELECT c.anio, c.mes, c.tipo, c.numero, c.monto, c.comisionCobrador, c.fechaAlta,
            a.nombre, a.apellido, a.tipo_documento, a.numero_documento, a.fecha_nacimiento,
            a.sexo, a.calle, a.numero, a.latitud, a.longitud, a.email, a.fecha_ingreso, a.fecha_egreso, 
            p.becado
            FROM App\Entity\Cuotas c
            INNER JOIN App\Entity\Pago p
            WHERE c.idCuota = p.cuota
            INNER JOIN App\Entity\Alumno a
            WHERE a.id = p.alumno";

        if($anio != null)
            $query_string .= " WHERE c.anio = :anio";

        if($id_alumno != null) 
            $query_string .= " and a.id = :id_alumno";

        $query_string .= " ORDER BY c.anio, c.mes";

        $query = $this->getEntityManager()->createQuery($query_string);
        
        if($anio != null)
            $query->setParameter('anio', (int)$anio);

        if($id_alumno != null)
            $query->setParameter('id_alumno', (int)$id_alumno);

        return $query->getResult();
    }

    public function cuotasInpagasParaDNI($dni, $anio) {

        $query_string = "
            SELECT c, pa.fecha_alta as fecha_pago
            FROM App\Entity\Cuotas c
            INNER JOIN App\Entity\Pago pa 
            WHERE c.idCuota = pa.cuota   
            WHERE c.idCuota NOT IN (
                SELECT IDENTITY(p.cuota) 
                FROM App\Entity\Pago p
                INNER JOIN App\Entity\Alumno a
                WHERE p.alumno = a.id
                WHERE a.numero_documento = :dni)
            and c.anio = :anio";

        $query = $this->getEntityManager()->createQuery($query_string);
        
        $query->setParameter('dni', $dni);
        $query->setParameter('anio', $anio);

        return $query->getResult();
    }

    public function cuotasPagasPorDNI($dni, $anio) {
        $query_string = "
            SELECT c.anio, c.mes, c.tipo, c.numero, c.monto, c.comisionCobrador, c.fechaAlta,
            a.nombre, a.apellido, a.tipo_documento, a.numero_documento, a.fecha_nacimiento,
            a.sexo, a.calle, a.numero, a.latitud, a.longitud, a.email, a.fecha_ingreso, a.fecha_egreso, 
            p.becado, p.fecha_alta as fecha_pago
            FROM App\Entity\Cuotas c
            INNER JOIN App\Entity\Pago p
            WHERE c.idCuota = p.cuota
            INNER JOIN App\Entity\Alumno a
            WHERE (a.id = p.alumno)
            WHERE a.numero_documento = :dni and c.anio = :anio
            ORDER BY c.anio, c.mes";

        $query = $this->getEntityManager()->createQuery($query_string);

        $query->setParameter('anio', (int)$anio);
        $query->setParameter('dni', (int)$dni);

        return $query->getResult();
    }
}

 ?>