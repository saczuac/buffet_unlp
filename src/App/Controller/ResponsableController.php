<?php 

namespace App\Controller;

use App\Controller\ResponsableController;
use App\Resource\ResponsableResource;

class ResponsableController extends AbstractController
{

	public function _new_() {
		return $this->getView()->render(
			'responsable/new.twig'
		);
	}

	public function create($app, $id_alumno) {
		$result = $this->getResource()->create($app->request, $id_alumno);	

		if (is_array($result)) {
			$app->flash('error', $result['exception']->getMessage());
			return $app->redirect($_SERVER['HTTP_REFERER']);
		} else {
			$app->flash('success', 'Responsable añadido exitosamente.');
			return $app->redirect(
				$result->getId() .'/edit'
			);
		}
	}

	public function edit($app, $id_responsable) {
		$responsable = $this->getResource()->get($id_responsable);
		return $this->getView()->render(
			'responsable/edit.twig',
			array('responsable' => $responsable)
		);
	}

	public function update($app, $id_responsable) {
		$responsable = $this->getResource()->update($app->request, $id_responsable);
		if(is_array($responsable)) {
			$app->flash('error', $responsable['exception']->getMessage());	
			return $app->redirect($_SERVER['HTTP_REFERER']);
		} else {
			$app->flash('success', 'Responsable actualizado exitosamente.');
			return $app->redirect('../'. $responsable->getId());
		}
		
	}

	public function show($id_responsable) {
		$responsable = $this->getResource()->get($id_responsable);
		return $this->getView()->render(
			'responsable/show.twig',
			array('responsable' => $responsable)
		);
	}

	public function select() {
		$responsables = $this->getResource()->get();
		return $this->getView()->render(
			'responsable/select.twig',
			array('responsables' => $responsables)
		);
	}

	public function assign($app, $id_alumno) {
		$this->getResource()->assign($id_alumno, $app->request->post('id_responsable'));
		$app->flash('success', 'Responsable asignado exitosamente');
		return $app->redirect('/alumnos/'. $id_alumno);
	}

	public function detach($app, $id_responsable, $id_alumno) {
		$this->getResource()->detach($id_responsable, $id_alumno);
		$app->flash('success', 'Responsable desasignado exitosamente');
		$app->redirect("/alumnos/$id_alumno");
	}
}

?>