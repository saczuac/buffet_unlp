<?php 

namespace App\Resource;

use App\Resource\AbstractResource;
use App\Entity\User;

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
            $users = $this->getEntityManager()->getRepository('App\Entity\User')->findAll();
            $data = $users;}
             else {
            $data = $this->getEntityManager()->find('App\Entity\User', $id);
        }

        // @TODO handle correct status when no data is found...

        return $data;
    }
    public function login($usuario,$pass)
    {
        $query = $this->getEntityManager()->createQuery('SELECT u FROM App\Entity\User u WHERE u.username = ?1 AND u.password = ?2');
        $query->setParameter(1, $usuario);
        $query->setParameter(2, $pass);
        $users = $query->getResult();
        if (count($users) === 0){
            return false;
        }else
        {return $this->getEntityManager()->find('App\Entity\User', $users[0]->getId());}
    }
    public function getLogin($usuario,$pass)
    {
        if ($this->login($usuario,$pass)){
                    $query = $this->getEntityManager()->createQuery('SELECT u FROM App\Entity\User u WHERE u.username = ?1');
                    $query->setParameter(1, $usuario);
                    $users = $query->getResult();
                    return $this->getEntityManager()->find('App\Entity\User', $users[0]->getId());
        }else{
            return "error";
        }
    }
    public function edit($id,$name,$rol,$email)
    {
        $user = $this->getEntityManager()->getReference('App\Entity\User', 1);
        $user->setName($name);
        $user->setEmail($email);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function delete($id)
    {
        $user = $this->getEntityManager()->getReference('App\Entity\User', $id);
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
        return $this->get();
    }
}

 ?>