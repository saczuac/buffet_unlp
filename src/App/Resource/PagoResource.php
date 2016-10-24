<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Resource\AlumnoResource;
use App\Resource\CuotasResource;
use App\Entity\Pago;

class PagoResource extends AbstractResource
{
	public function create($request, $id_alumno) {
		$pago = new Pago;

		$alumnoResource = new AlumnoResource;
		$alumno = $alumnoResource->get($id_alumno);

		$cuotaResource = new CuotasResource;
		$cuota = $cuotaResource->get($request['id']);

		if($request['tipo'] == 'becar')
			$pago->setBecado(true);
		else 
			$pago->setBecado(false);

		$pago->setFechaAlta(new \DateTime());
		$pago->setFechaActualizado(new \DateTime());

		$pago->setAlumno($alumno);
		$pago->setCuota($cuota);
		$pago->setCobrador($_SESSION['user']);

		$this->getEntityManager()->merge($pago);
		$this->getEntityManager()->flush();
	}

	public function matriculasPagas() {
		$query = $this->getEntityManager()->createQuery(
			"SELECT a
			FROM App\Entity\Alumno a
			WHERE a.id IN (
				SELECT IDENTITY(p.alumno) 
				FROM App\Entity\Pago p 
				INNER JOIN App\Entity\Cuotas c
				WHERE p.cuota = c.idCuota
				WHERE c.tipo = :tipo)"
		);
		$query->setParameter('tipo', 'matricula');
		return $query->getResult();
	}
	public function matriculasPagasEx() {
		$query = $this->getEntityManager()->createQuery(
			"SELECT a.nombre,a.tipo_documento,a.numero_documento,a.apellido,a.fecha_nacimiento
			FROM App\Entity\Alumno a
			WHERE a.id IN (
				SELECT IDENTITY(p.alumno) 
				FROM App\Entity\Pago p 
				INNER JOIN App\Entity\Cuotas c
				WHERE p.cuota = c.idCuota
				WHERE c.tipo = :tipo)"
		);
		$query->setParameter('tipo', 'matricula');
		return $query->getResult();
	}
	public function comision($usr) {
        $query_string = "
            SELECT c.anio, c.mes, SUM((c.monto * c.comisionCobrador)/100) as comision
            FROM App\Entity\Cuotas c
            INNER JOIN App\Entity\Pago p
            WHERE c.idCuota = p.cuota
            WHERE p.cobrador = :usr
            GROUP BY c.anio, c.mes
            ORDER BY c.anio, c.mes";

        $query = $this->getEntityManager()->createQuery($query_string);

        $query->setParameter('usr',$usr);

        return $query->getResult();
    }
}