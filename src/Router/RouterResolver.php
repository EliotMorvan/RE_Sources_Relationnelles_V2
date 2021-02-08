<?php

namespace Router;

use Controller\AbstractController;
use Phroute\Phroute\HandlerResolverInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class RouterResolver implements HandlerResolverInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler)
    {
        if (!is_array($handler)) {
            return $handler;
        }

        if (!(is_string($handler[0]) && class_exists($handler[0]))) {
            return $handler;
        }

        // Utilise le conteneur de services pour instancier le contrôleur
        // et bénéficier de l'injection de dépendances.
        $controller = $this->container->get($handler[0]);

        // Si le contrôleur hérite de AbstractController
        if ($controller instanceof AbstractController) {
            // Injecte le moteur de template
            $controller->setTwig($this->container->get(Environment::class));
            // Injecte le routeur
            $controller->setRouter($this->container->get(Router::class));
        }

        $handler[0] = $controller;

        return $handler;
    }
}
