<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Model\Resource\AbstractResource;

$entityManager = AbstractResource::getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);

?>
