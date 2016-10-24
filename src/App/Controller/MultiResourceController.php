<?php 

namespace App\Controller;

use App\Controller\AbstractController;

class MultiResourceController extends AbstractController
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
			'cuotas' => new \App\Resource\CuotasResource(),
			'pagos' => new \App\Resource\PagoResource()
		);
		$this->resources = $referencedResources;
	}

	public function getResources($resource = null) {
		if(is_null($resource)) {
			return $this->resources;
		}
		return $this->resources[$resource];
	}
}

?>