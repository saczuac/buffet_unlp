<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\Proyecto;
use App\Entity\Cliente;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


/**
 * Class Resource
 * @package App
 */

class ClienteResource extends AbstractResource
{
    public function duplicado($nombre){
        $query_string = "
            SELECT count(c) FROM App\Entity\Cliente c
            WHERE c.nombreCliente = :nombre";

        $query = $this->getEntityManager()->createQuery($query_string);
        
        $query->setParameter('nombre', $nombre);

        $count = $query->getResult();
    return $count;
    }
	public function get($id = null)
    {
        if ($id === null) {
            $responsables = $this->getEntityManager()->getRepository('App\Entity\Cliente')->findAll();
        } else {
            $responsables = $this->getEntityManager()->find('App\Entity\Cliente', $id);
        }

        return $responsables;
    }

    public function delete($id)
    {
            $cliente = $this->getEntityManager()->find('App\Entity\Cliente', $id);
            $this->getEntityManager()->remove($cliente);
            if ($cliente->getProyectos()->isEmpty()) {
                                      try {
            $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;
            }

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

        public function Nuevo ($cli,$desc,$fecha){
        $cliente = new Cliente();
        $cliente->setNombreCliente($cli);
        $cliente->setDescripcion($desc);
        $cliente->setFechaIngreso(new \DateTime($fecha));
        return $cliente;        
    }
    public function Edit ($id,$desc,$fecha){
        $cliente = $this->getEntityManager()->find('App\Entity\Cliente', $id);
        $cliente->setDescripcion($desc);
        $cliente->setFechaIngreso(new \DateTime($fecha));
        $this->getEntityManager()->persist($cliente);
           try {
            $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;
    }      


    
    public function insert($cli,$desc,$fecha){
        
            $this->getEntityManager()->persist($this->Nuevo($cli,$desc,$fecha));
           try {
            $this->getEntityManager()->flush();
                    } catch (UniqueConstraintViolationException $e){
            return false;
        }
            return true;

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

    public function assign($id_cliente, $id_proyecto) {
        
        $proyectoResource = new ProyectoResource;
        
        $cliente = $this->get($id_cliente);

        $proyecto = $proyectoResource->get($id_proyecto);

        $proyecto->addCliente($cliente);
        $cliente->addProyect($proyecto);

        try {
            $proyectoResource->getEntityManager()->persist($proyecto);
            //$alumnoResource->getEntityManager()->flush();
            $this->getEntityManager()->persist($proyecto);
            $this->getEntityManager()->flush();
        }
        catch(Exception $e){
            return array('exception' => $e);
        }
        return $cliente;
    }

    public function detach($id_cliente, $id_proyecto) {
    	$proyectoResource = new ProyectoResource;
		
        $cliente = $this->get($id_cliente);

        $proyecto = $proyectoResource->get($id_proyecto);
        $cliente->removeProyecto($proyecto);
        $proyecto->removeCliente($cliente);
        

		try {
			$proyectoResource->getEntityManager()->merge($cliente);
            $proyectoResource->getEntityManager()->flush();
            return $cliente;
		}
		catch(Exception $e) {
			return array('exception' => $e);
		}
    }
}

 ?>