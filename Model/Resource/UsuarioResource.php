<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Usuario;
/**
 * Class Resource
 * @package Model
 */
class UsuarioResource extends AbstractResource {
    /**
     * @param $id
     *
     * @return string
     */
    public function get($id = null)
    {
        if ($id === null) {
            $usuarios = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findAll();
            $data = $usuarios;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Usuario', $id);
        }
        return $data;
    }

   public function edit($id,$nombre,$email,$rol_id)
    {
        $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
        $usuario->setName($nombre);
        $usuario->setEmail($email);
        $usuario->setRol_Id($rol_id);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }

   public function cambiarPass($id,$pass)
    {
        $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
        $usuario->setClave($pass);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function delete($id)
    {
        $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
        $this->getEntityManager()->remove($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function Nuevo ($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email){
        $usuario = new Usuario();
        $usuario->setUsername($user);
        $usuario->setClave($pass);
        $usuario->setNombre($nombre);
        $usuario->setRol_Id($rol_id);
        $usuario->setEmail($email);
        $usuario->setTelefono($telefono);
        $usuario->setDocumento($documento);
        $usuario->setApellido($apellido);
        return $usuario;
    }
    public function insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email){
        $this->getEntityManager()->persist($this->Nuevo($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email));
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function login($username, $pass)
    {
        $data = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findOneBy(array('username' => $username));
        if ($data != null) {
          if (($data->getClave() == $pass)) return $data;
          else return false;
        }
        else return false;
    }
}

?>