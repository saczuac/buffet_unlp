<?php 

namespace App\Resource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

abstract class AbstractResource
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private static $entityManager = null;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (self::$entityManager === null) {
            self::$entityManager = self::createEntityManager();
        }

        return self::$entityManager;
    }

    /**
     * @return EntityManager
     */
    public function createEntityManager()
    {
        $path = array('src/App/Entity');
        $devMode = true;

        $config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

        // define credentials...
        $connectionOptions = array(
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'dbname'   => 'grupo_38',
            'user'     => 'grupo_38',
            'password' => 'wypeJ5fHqBUxVVo1'
        );

        return EntityManager::create($connectionOptions, $config);
    }
}

 ?>