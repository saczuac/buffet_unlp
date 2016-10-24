<?php

require 'vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;

$path = array('src/App/Entity');
$devMode = true;

$config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

$connectionOptions = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'grupo_38',
    'user'     => 'root',
    'password' => 'powerofdata',
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helpers = new Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));