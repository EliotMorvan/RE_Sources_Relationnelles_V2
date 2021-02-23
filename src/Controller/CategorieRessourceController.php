<?php

namespace Controller;

use Http\Response;
use Manager\CategorieRessourceManager;
use Twig\Environment;
use Repository\CategorieRessourceRepository;

class CategorieRessourceController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var CategorieRessourceManager
     */
    private $manager;

    /**
     * @var CategorieRessourceRepository
     */
    private $repository;

    public function __construct(
        Environment $twig, 
        CategorieRessourceRepository $repository,
        CategorieRessourceManager $manager)
    {
        $this->twig = $twig;
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function index(): Response
    {
        return new Response("");
    }

    public function createCategorieRessource(): Response
    {
        return new Response("");
    }

    public function updateCategorieRessource(int $id): Response
    {
        return new Response("");
    }
}
