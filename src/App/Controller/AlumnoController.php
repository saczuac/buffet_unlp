<?php 

namespace App\Controller;

use App\Controller\AbstractController;

class AlumnoController extends AbstractController
{

	public function index($request = null) {
		$alumnos = $this->getResource()->get();
		return $this->getView()->render(
			'alumnos/index.twig', 
				array('alumnos' => $alumnos)
		);
	}

	public function show($id) {
		$alumno = $this->getResource()->get($id);
		return $this->getView()->render(
			'/alumnos/show.twig', 
			array('alumno' => $alumno)
		);
		return $alumno->getResponsables();
	}

	public function _new_() {
		return $this->getView()->render(
			'alumnos/new.twig'
		);
	}

	public function create($app) {
		$app->flash('success', 'Alumno creado exitosamente.');
		$alumno = $this->getResource()->save($app->request);
		return $app->redirect('/alumnos');
	}

	public function edit($id) {
		$alumno = $this->getResource()->get($id);
		return $this->getView()->render(
			'alumnos/edit.twig',
			array('alumno' => $alumno)
		);
	}

	public function update($app, $id) {
		$app->flash('success', 'Alumno editado exitosamente.');
		$alumno = $this->getResource()->save($app->request, $id);
		$app->flash('success', 'Alumno actualizado con exito');
		$app->redirect('/alumnos');
	}

	public function delete($app, $id) {
		$app->flash('success', 'El alumno ha sido eliminado exitosamente.');
		$alumno = $this->getResource()->delete($id);
		return $app->redirect('/alumnos');
	}

	public function recorridos($app) {
		return $this->getResource()->getAll($app->request);
	}
}

 ?>