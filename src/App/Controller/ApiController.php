<?php 

namespace App\Controller;

use App\Controller\AbstractController;
use App\Resource\CuotasResource;
use App\Resource\AlumnoResource;


class ApiController extends AbstractController
{
	public function cuotasPara($dni, $anio) {
		$cuotasResource = new CuotasResource();
		$cuotasImpagas = $cuotasResource->cuotasInpagasParaDNI($dni, $anio);
		$cuotasPagas = $cuotasResource->cuotasPagasPorDNI($dni, $anio);
		
		$cuotas = array(	'impagas' => $cuotasImpagas,
							'pagas'   => $cuotasPagas
				);

		return $this->getJson($cuotas);	
	}

	public function ingresosParaAnio($anio) {
		$alumnoResource = new AlumnoResource();
		$ingresos = $alumnoResource->ingresosParaAnio($anio);

		return $this->getJson($ingresos);
	}
}
