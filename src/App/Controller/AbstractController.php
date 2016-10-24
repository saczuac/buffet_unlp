<?php 

namespace App\Controller;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

abstract class AbstractController
{

	private $resource;

	private $view;

	private $serializer;

	public function __construct($view, $resource = null) {
		$this->setView($view);
		$this->setResource($resource);
		$this->setSerializer(
			new Serializer(array(
				new GetSetMethodNormalizer()), 
			array('json' => new JsonEncoder())));
		return $this;
	}

	public function getView() {
		return $this->view;
	}

	public function setView($view) {
		$this->view = $view;
	}

	public function getResource() {
		return $this->resource;
	}

	public function getSerializer() {
		return $this->serializer;
	}

	public function setResource($resource) {
		$this->resource = $resource;
	}

	public function setSerializer($serializer) {
		$this->serializer = $serializer;
	}

	public function getJson($entity) {
		return $this->getSerializer()->serialize($entity, 'json');
	}
}

 ?>