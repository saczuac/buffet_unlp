<?php

namespace Model\Resource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

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
        $config = new Configuration;
        $driverImpl = $config->newDefaultAnnotationDriver('Model/Entity');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setProxyDir('uploads');
        $config->setProxyNamespace('uploads');
        $config->setAutoGenerateProxyClasses(true);

        // define credentials...
        $connectionOptions = array(
            'driver'   => 'pdo_mysql',
            'host'     => '127.0.0.1',
            'dbname'   => 'grupo17',
            'user'     => 'grupo17',
            'password' => ''
        );

        return EntityManager::create($connectionOptions, $config);
    }

}

 ?>
