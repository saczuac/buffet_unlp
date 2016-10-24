<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Responsable;
use App\Resource\Alumno;

/**
 * Class Resource
 * @package App
 */

class ResponsableResource extends AbstractResource
{
	public function get($id = null)
    {
        if ($id === null) {
            $responsables = $this->getEntityManager()->getRepository('App\Entity\Responsable')->findAll();
        } else {
            $responsables = $this->getEntityManager()->find('App\Entity\Responsable', $id);
        }

        return $responsables;
    }

    private function assign_params($request, $responsable)
    {
    	$responsable->setNombre($request->params('nombre'));
		$responsable->setApellido($request->params('apellido'));
		$responsable->setFechaNacimiento(
			new \DateTime($request->params('fecha_nacimiento'))
		);
		$responsable->setSexo($request->params('sexo'));
		$responsable->setTipo($request->params('tipo'));
		$responsable->setEmail($request->params('email'));
		$responsable->setTelefono($request->params('telefono'));
		$responsable->setDireccion($request->params('direccion'));
    }

    public function create($request, $id_alumno = null)
    {

    	$responsable = new Responsable;

    	if(!is_null($id_alumno)) {
    		$alumnoResource = new AlumnoResource;
    		$alumno = $alumnoResource->get($id_alumno);
    		$responsable->addAlumno($alumno);
    	}

		$this->assign_params($request, $responsable);
		
		try {
			$alumnoResource->getEntityManager()->merge($alumno);
			$alumnoResource->getEntityManager()->flush();	
		}
		catch(Exception $e){
			return array('exception' => $e);
		}
		return $responsable;
    }

    public function update($request, $id_responsable) {
        $responsable = $this->get($id_responsable);
        $this->assign_params($request, $responsable);

        try {
            $this->getEntityManager()->merge($responsable);
            $this->getEntityManager()->flush();
        }
        catch(Exception $e) {
            return array('exception' => $e);
        }
        return $responsable;
    }

    public function assign($id_alumno, $id_responsable) {
        
        $alumnoResource = new AlumnoResource;
        
        $responsable = $this->get($id_responsable);

        $alumno = $alumnoResource->get($id_alumno);

        $alumno->addResponsable($responsable);
        $responsable->addAlumno($alumno);

        try {
            $alumnoResource->getEntityManager()->persist($alumno);
            //$alumnoResource->getEntityManager()->flush();
            $this->getEntityManager()->persist($responsable);
            $this->getEntityManager()->flush();
        }
        catch(Exception $e){
            return array('exception' => $e);
        }
        return $responsable;
    }

    public function detach($id_responsable, $id_alumno) {
    	$alumnoResource = new AlumnoResource;
		
		$alumno = $alumnoResource->get($id_alumno);
		$responsable = $this->get($id_responsable);

		$responsable->removeAlumno($alumno);
		$alumno->removeResponsable($responsable);

		try {
			$alumnoResource->getEntityManager()->merge($alumno);
            $alumnoResource->getEntityManager()->flush();
            return $responsable;
		}
		catch(Exception $e) {
			return array('exception' => $e);
		}
    }
}

 ?>