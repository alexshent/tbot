<?php

require_once "vendor/autoload.php";

require_once 'bootstrap.php';

use alexshent\tbot\entities\User;

$user = new User();
$user->setId("id1");
$user->setFirstName("fn");
$user->setUsername("un");

$entityManager->persist($user);
$entityManager->flush();

//$user = $entityManager->find('alexshent\tbot\entities\User', 123);
print_r($user);
