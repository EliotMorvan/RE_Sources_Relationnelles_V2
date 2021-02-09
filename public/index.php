<?php

use Http\Request;

require __DIR__ . '/../vendor/autoload.php';

// Instancie le kernel
// (le second paramètre active le mode débogage)
$kernel = new Kernel(realpath(__DIR__ . '/..'), true);
// Créé une requête d'après les variables globales
$request = Request::createFromGlobals();
// Le kernel traite la requête et renvoie une réponse
$response = $kernel->handleRequest($request);
// Envoie la réponse au navigateur
$response->send();
//test
