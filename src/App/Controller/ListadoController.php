<?php 

namespace App\Controller;

use App\Controller\MultiResourceController;

class ListadoController extends MultiResourceController
{
	public function matriculasPagas() {
		$listado = $this->getResources('pagos')->matriculasPagas();
		return $this->getView()->render(
			'listados/matriculas_pagas.twig',
			array('listado' => $listado)
		);
	}

	public function cuotasPagas() {
		$listado = $this->getResources('cuotas')->cuotasPagas();
		return $this->getView()->render(
			'listados/cuotas_pagas.twig',
			array('listado' => $listado)
		);
	}

	public function cuotasInpagas() {
		$listado = $this->getResources('cuotas')->cuotasInpagas();
		return $this->getView()->render(
			'listados/cuotas_inpagas.twig',
			array('listado' => $listado)
		);
	}
	public function comision() {
		$listado = $this->getResources('pagos')->comision($_SESSION['user']);
		return $this->getView()->render(
			'listados/comision.twig',
			array('listado' => $listado)
		);
	}

}

?>