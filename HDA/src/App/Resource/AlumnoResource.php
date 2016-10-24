<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Alumno;

/**
 * Class Resource
 * @package App
 */
class AlumnoResource extends AbstractResource
{
	public function get($id = null)
    {
        if ($id === null) {
            $alumnos = $this->getEntityManager()->getRepository('App\Entity\Alumno')->findAll();
            $alumnos = array_map(function($alumno) {
                return $this->convertToArray($alumno); },
                $alumnos);
            $data = $alumnos;
        } else {
            $data = $this->convertToArray($this->getEntityManager()->find('App\Entity\Alumno', $id));
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

    private function convertToArray(Alumno $alumno) {
        return array(
            'id' => $alumno->getId(),
            'tipo_documento' => $alumno->getTipoDocumento(),
            'numero_documento' => $alumno->getNumeroDocumento(),
            'apellido' => $alumno->getApellido(),
            'nombre' => $alumno->getNombre(),
            'fecha_nacimiento' => $alumno->getFechaNacimiento(),
            'sexo' => $alumno->getSexo(),
            'direccion' => $alumno->getDireccion(),
            'fecha_ingreso' => $alumno->getFechaIngreso(),
            'fecha_egreso' => $alumno->getFechaEgreso(),
            'fecha_alta' => $alumno->getFechaAlta()
        );
    }
    
}

 ?>