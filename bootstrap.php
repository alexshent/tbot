<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use alexshent\tbot\Config;

$paths = [__DIR__ . "/src/entities"];
$isDevMode = true;
$config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create(Config::DB_CONNECTION, $config);
