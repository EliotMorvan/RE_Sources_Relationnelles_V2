<?php

namespace Controller;

use Entity\Ressource;
use Entity\User;
Use Entity\favoris;
use Security\Security;
use Twig\Environment;

use Http\Response;
use Repository\FavorisRepository;

class FavorisController extends AbstractController
{ 

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Securiry
     */
    private $security;

    private $repository;


   public function __construct(
        Environment $twig, 
        Security $security,
        FavorisRepository $repository)
    {
        $this->twig = $twig;
        $this->security = $security;
        $this->repository = $repository;
    }

    public function index(): Response
    {
        // recup de l'uitilsateur connecté à ce moment
        // reup des favoris de ce mec là
        $favoris = $this->repository->findAll();

        // envoie de ces favoris à la page twig
        $content = $this->twig->render('favoris/index.html.twig', [
            'favoris' => $favoris,
        ]);

        return new Response($content);
    }
}