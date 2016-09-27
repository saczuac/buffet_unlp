<?php

namespace Model\Resource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

abstract class AbstractResource
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private static $entityManager = null;
    private static $instance;
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
        $path = array('Model/Entity');
        $devMode = true;

        $config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

        // define credentials...
        $connectionOptions = array(
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'dbname'   => 'grupo17',
            'user'     => 'grupo17',
            'password' => 'Reev5Pho8o'
        );

        return EntityManager::create($connectionOptions, $config);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
          self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}
}

 ?>
