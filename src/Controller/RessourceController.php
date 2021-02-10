<?php

// src/Controller/RessourceController.php

namespace Controller;

use Entity\User;
use Entity\Ressource;
use Http\Response;
use Twig\Environment;
use Repository\RessourceRepository;

class RessourceController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var RessourceRepository
     */
    private $repository;

    public function __construct(Environment $twig, RessourceRepository $repository)
    {
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function index(): Response
    {
        $ressources = $this->repository->findAll();
        $content = $this->twig->render('ressource/index.html.twig', [
            'ressources' => $ressources,
        ]);

        return new Response($content);
    }
}
