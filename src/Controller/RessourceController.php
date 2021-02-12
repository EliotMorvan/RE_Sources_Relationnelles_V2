<?php

// src/Controller/RessourceController.php

namespace Controller;

use Entity\User;
use Entity\Ressource;
use Http\Response;
use Twig\Environment;
use Repository\RessourceRepository;
use Manager\RessourceManager;

class RessourceController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var RessourceManager
     */
    private $manager;

    /**
     * @var RessourceRepository
     */
    private $repository;

    public function __construct(
        Environment $twig, 
        RessourceRepository $repository,
        RessourceManager $manager)
    {
        $this->twig = $twig;
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function index(): Response
    {
        $currentUSer = $this->security->getUser();
        $ressources = $this->repository->findAll();
        $content = $this->twig->render('ressource/index.html.twig', [
            'ressources' => $ressources,
        ]);

        return new Response($content);
    }

    public function createRessource(): Response
    {
        $ressource = new Ressource();
        $createur = new User();
        $createur->setId(13);

        if (isset($_POST['create_ressource'])) {
            $ressource
                ->setTitre($_POST['titre'])
                ->setContenu($_POST['contenu'])
                ->setCreateur($createur);

                $this->manager->insert($ressource);
        }

        $content = $this->twig->render('ressource/create.html.twig');
        return new Response($content);
    }
}
