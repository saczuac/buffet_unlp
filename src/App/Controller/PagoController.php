<?php 

namespace App\Controller;

use App\Controller\AbstractController;
use App\Resource\AlumnoResource;
use App\Resource\CuotasResource;

class PagoController extends AbstractController
{

	/*
	 * @var array referencedResources
 	 *
	 */
	protected $resources;

	public function __construct($view, $resource = null) {
		parent::__construct($view, $resource);
		$referencedResources = array(
			'alumnos' => new \App\Resource\AlumnoResource(),
			'cuotas' => new \App\Resource\CuotasResource()
		);
		$this->resources = $referencedResources;
	}

	public function getResources($resource = null) {
		if(is_null($resource)) {
			return $this->resources;
		}
		return $this->resources[$resource];
	}

	public function index() {
		$alumnos = $this->getResources('alumnos')->get();
		return $this->getView()->render(
			'pagos/index.twig',
			array('alumnos' => $alumnos)
		);
	}

	public function pagos($app, $id_alumno) {
		$alumno = $this->getResources('alumnos')->get($id_alumno);
		$cuotasResource = new CuotasResource();
		$cuotas = $cuotasResource->cuotasInpagasPara($id_alumno);

		return $this->getView()->render(
			'pagos/show.twig',
			array(
				'alumno' => $alumno,
				'cuotas' => $cuotas
			)
		);
	}

	public function create($app, $id_alumno) {
		$cuotas = $app->request->post('cuotas');
		$cuotas = $this->filter_unselected($cuotas);

		foreach ($cuotas as $cuota) {
			$this->getResource()->create($cuota, $id_alumno);
		}

		return header("Refresh:0");
	}

	private function filter_unselected($cuotas) {
		$callback = function($cuota){
			return $cuota['tipo'] == 'becar' ||
					$cuota['tipo'] == 'pagar';
		};
		return  array_filter($cuotas, $callback);
	}
}