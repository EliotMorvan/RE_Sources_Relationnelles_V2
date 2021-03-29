<?php

namespace Controller;

use Http\Response;
use Manager\CategorieRessourceManager;
use Twig\Environment;
use Repository\CategorieRessourceRepository;
use Repository\RessourceRepository;
use Entity\TypeRessource;

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

    private $ressourceRepository;

    public function __construct(
        Environment $twig, 
        CategorieRessourceRepository $repository,
        CategorieRessourceManager $manager,
        RessourceRepository $ressourceRepository)
    {
        $this->twig = $twig;
        $this->repository = $repository;
        $this->manager = $manager;
        $this->ressourceRepository = $ressourceRepository;
    }

    public function index(int $id): Response
    {
        $categorie = $this->repository->findOneById($id);
        $ressources = $this->ressourceRepository->findAllForCategory($id);
        $content = $this->twig->render('categorieRessource/index.html.twig', [
            'categorie'  => $categorie,
            'ressources' => $ressources,
        ]);

        return new Response($content);
    }

    public function indexType(string $nom): Response
    {
        $typeId = array_search($nom, TypeRessource::types)+1;
        $ressources = $this->ressourceRepository->findAllFortype($typeId);
        $content = $this->twig->render('typeRessource/index.html.twig', [
            'type'  => $nom,
            'ressources' => $ressources,
        ]);

        return new Response($content);
    }

    public function liste(): Response {
        $categories = $this->repository->findAll();
        $content = $this->twig->render('categorieRessource/liste.html.twig', [
            'categories' => $categories,
        ]);

        return new Response($content);
    }

    public function listeType(): Response {
        $types = TypeRessource::types;
        $content = $this->twig->render('typeRessource/liste.html.twig', [
            'types' => $types,
        ]);

        return new Response($content);
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
