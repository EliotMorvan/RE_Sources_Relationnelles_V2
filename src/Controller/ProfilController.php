<?php

namespace Controller;

use Entity\User;
Use Entity\favoris;
use Security\Security;
use Twig\Environment;

use Http\Response;
use Manager\UserManager;
use Repository\ProfilRepository;

class ProfilController extends AbstractController
{ 

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Securiry
     */
    private $security;

    /**
     * @var ProfilRepository
     */
    private $repository;

    private $manager;


   public function __construct(
        Environment $twig, 
        Security $security,
        UserManager $manager,
        ProfilRepository $repository)
    {
        $this->twig = $twig;
        $this->security = $security;
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function index(): Response
    {
        $profil = $this->repository->findProfilById($this->security->getUser());

        // envoie de ces favoris à la page twig
        $content = $this->twig->render('profil/index.html.twig', [
            'profil' => $profil,
        ]);

        return new Response($content);
    }
}