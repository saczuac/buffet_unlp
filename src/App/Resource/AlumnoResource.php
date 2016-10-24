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
        } else {
            $alumnos = $this->getEntityManager()->find('App\Entity\Alumno', $id);
        }

        return $alumnos;
    }

    /*
     * Retorna un arreglo con las entidades correspondientes
     * al arreglo de ids pasado como parámetro.
     *
     * @author: Santiago José Figueiras
     */

    public function getAll($request) {
        $alumnos = array();
        $ids = $request->post('alumnos');
        foreach ($ids as $id) {
            $alumno = $this->get((int)$id);
            $alumnos[] =  array
            (   "id"        => $alumno->getId(),
                "nombre"    => $alumno->getNombre(),
                "apellido"  => $alumno->getApellido(),
                "longitud"  => $alumno->getLongitud(),
                "latitud"   => $alumno->getLatitud()
            );
        };
        return $alumnos;
    }

    private function assign_params($request, $alumno) {
        $today = new \DateTime("now");

        $alumno->setTipoDocumento($request->params('tipo_documento'));
        $alumno->setNumeroDocumento($request->params('numero_documento'));
        $alumno->setApellido($request->params('apellido'));
        $alumno->setNombre($request->params('nombre'));
        $alumno->setFechaNacimiento(
            new \DateTime($request->params('fecha_nacimiento'))
        );
        $alumno->setSexo($request->params('sexo'));
        $alumno->setFechaIngreso(
            new \DateTime($request->params('fecha_ingreso'))
        );
        $alumno->setFechaAlta($today);
        $alumno->setFechaEgreso(
            new \DateTime($request->params('fecha_egreso'))
        );
        $alumno->setCalle($request->params('calle'));
        $alumno->setNumero($request->params('numero'));
        $alumno->setLongitud($request->params('longitud'));
        $alumno->setLatitud($request->params('latitud'));
        $alumno->setEmail($request->params('email'));
    }

    public function save($request, $id = null) {

        if(is_null($id)) {
            $alumno = new Alumno();
        } else {
            $alumno = $this->get($id);
        }
       
        $this->assign_params($request, $alumno);
        
        try {
            is_null($id) ? 
                $this->getEntityManager()->persist($alumno) :
                $this->getEntityManager()->merge($alumno);
            
            $this->getEntityManager()->flush();
            return true;
        }
        catch(Exception $e) {
            return false;
        }
        return true;
    }

    public function delete($id) {
        $alumno = $this->getEntityManager()->find('App\Entity\Alumno', $id);
        $this->getEntityManager()->remove($alumno);
        $this->getEntityManager()->flush();
        return true;
    }

    public function ingresosParaAnio($anio) {
        $query_string = "
            select MONTHNAME(fecha_ingreso) as mes, COUNT(a.id) as cantidad
            from alumno a
            where YEAR(fecha_ingreso) = ?
            group by MONTH(fecha_ingreso)
            order by MONTH(fecha_ingreso) asc";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query_string);
        $stmt->execute(array($anio));

        return $stmt->fetchAll();
    }
    
}

 ?>