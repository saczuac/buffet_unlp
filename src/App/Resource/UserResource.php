<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Resource\Responsable;
use App\Entity\User;
use App\Entity\Hora;
use App\Entity\Cliente;
use App\Entity\Proyecto;
use App\Entity\Item;
use App\Entity\Tarea;
/**
 * Class Resource
 * @package App
 */
class UserResource extends AbstractResource
{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $usuarios = $this->getEntityManager()->getRepository('App\Entity\User')->findAll();
            $data = $usuarios;}
         else {
            $data = $this->getEntityManager()->find('App\Entity\User', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }

    // POST, PUT, DELETE methods...

   public function edit($id,$name,$habilitado,$email,$rol)
    {
        $usuario = $this->getEntityManager()->getReference('App\Entity\User', $id);
        $usuario->setName($name);
        $usuario->setHabilitado($habilitado);
        $usuario->setEmail($email);
        $usuario->setRol($rol);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }

   public function cambiarPass($id,$pass)
    {
        $usuario = $this->getEntityManager()->getReference('App\Entity\User', $id);
        $usuario->setPassword($pass);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function delete($id)
    {
        $usuario = $this->getEntityManager()->getReference('App\Entity\User', $id);
        $this->getEntityManager()->remove($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }
        public function Nuevo ($user,$pass,$name,$rol,$email){ 
        $usuario = new User();
        $usuario->setUsername($user);
        $usuario->setPassword($pass);
        $usuario->setName($name);
        $usuario->setRol($rol);
        $usuario->setEmail($email);
        $usuario->setHabilitado('1');
        return $usuario;        
    }
    public function insert($user,$pass,$name,$rol,$email){
        $this->getEntityManager()->persist($this->Nuevo($user,$pass,$name,$rol,$email));
        $this->getEntityManager()->flush();
        return $this->get();

}
    public function login($user, $pass)
    {
        $data = $this->getEntityManager()->getRepository('App\Entity\User')->findOneBy(array('username' => $user));
        if ($data != null){
        if (($data->getPassword() == $pass))
            return $data; 
        else
            return false;}
        else return false;
    }
    public function habilitar($id)
    {$data = $this->getEntityManager()->find('App\Entity\User', $id);
        $data->setHabilitado(1);
        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->flush();
        return true;
    }
    public function deshabilitar($id)
    {$data = $this->getEntityManager()->find('App\Entity\User', $id);
        $data->setHabilitado(0);
        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->flush();
        return true;
    }

    public function asignar($request) {
        $usuario = $this->getEntityManager()
                    ->find('App\Entity\User', $request->put('id_usuario'));

        if($usuario->getResponsable() == 0){
            $responsableResource = new ResponsableResource;
            $responsable = $responsableResource->get($request->put('id_responsable'));

            $usuario->asignarResponsable($responsable);
            
            try {
                $this->getEntityManager()->merge($usuario);
                $this->getEntityManager()->flush();
                return true;
            }
            catch(Exception $e) {
                return false;
            }

        } else {
            return false;
        }
    }

    public function desasignar($id_usuario) {
        $usuario = $this->getEntityManager()
                    ->find('App\Entity\User', $id_usuario);
        $usuario->desasignarResponsable();
        try {
            $this->getEntityManager()->merge($usuario);
            $this->getEntityManager()->flush();
            return true;
        }
        catch(Exception $e) {
            return false;
        }
    }
        public function comision($usr,$dtdesde = null,$dthasta = null) {
        $query_string = "
            SELECT h.fecha as fecha
            FROM App\Entity\User u
            JOIN u.horas h
            JOIN h.proyecto p
            JOIN h.item i
            JOIN h.tarea t 
            WHERE u.id = :usr";
             if ($dtdesde === null){
                            $query = $this->getEntityManager()->createQuery($query_string);

                              $query->setParameter('usr',$usr);
             }else{
                $query_string .="WHERE h.fecha > :dtdesde
                                 WHERE h.fecha < :dthasta";
                             $query = $this->getEntityManager()->createQuery($query_string);

                             $query->setParameters(array(usr => $usr,dtdesde  =>$dtdesde, dthasta  =>$dthasta ));
             }

        return $query->getResult();
    }
}

?>