<?php

// src/Controller/RessourceController.php

namespace Controller;

use Entity\User;
use Entity\Ressource;
use Http\Response;
use Twig\Environment;
use Repository\RessourceRepository;

class RessourceController extends AbstractController
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
    public function createRessource(): Response
    {
        $ressource = new Ressource();
           
            //if (isset($_POST['create_ressource'])) {
            //$ressource
              //  ->setTitre($_POST['titre'])
                //->setContenu($_POST['contenu'])
                //->setIdCreateur($_POST['IdCreateur']);
            
               //$this->manager->insert($ressource);

                //return $this->redirectToRoute('liste_ressources');
           // }
                
        return $this->render('ressource/createRessource.html.twig');
    }
}
