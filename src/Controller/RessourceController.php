<?php

// src/Controller/RessourceController.php

namespace Controller;

use Entity\User;
use Entity\Ressource;
use Http\Response;
use Twig\Environment;
use Repository\RessourceRepository;
use Manager\RessourceManager;
use Security\Security;

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

    /**
     * @var Security
     */
    private $security;

    public function __construct(
        Environment $twig, 
        RessourceRepository $repository,
        RessourceManager $manager,
        Security $security)
    {
        $this->twig = $twig;
        $this->repository = $repository;
        $this->manager = $manager;
        $this->security = $security;
    }

    public function index(): Response
    {
        $currentUSer = $this->security->getUser();
        $ressources = $this->repository->findAll();
        $content = $this->twig->render('ressource/index.html.twig', [
            'ressources' => $ressources,
            'currentUser' => $currentUSer,
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
