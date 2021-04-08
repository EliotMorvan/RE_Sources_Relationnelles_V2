<?php

namespace Controller;

use Entity\Ressource;
use Entity\User;
Use Entity\favoris;
use Security\Security;
use Twig\Environment;

use Http\Response;
use Manager\FavorisManager;
use Repository\FavorisRepository;
use Repository\RessourceRepository;

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

    /**
     * @var RessourceRepository
     */
    private $ressourceRepository;

    private $manager;

    private $repository;


   public function __construct(
        Environment $twig, 
        Security $security,
        FavorisRepository $repository,
        FavorisManager $manager,
        RessourceRepository $ressourceRepository)
    {
        $this->twig = $twig;
        $this->security = $security;
        $this->repository = $repository;
        $this->manager = $manager;
        $this->ressourceRepository = $ressourceRepository;
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

    public function create(int $idRessource): Response
    {
        $favoris = new Favoris();
        $ressource = $this->ressourceRepository->findOneById($idRessource);

        $favoris->setCreateur($this->security->getUser());
        $favoris->setRessouce($ressource);

        $this->manager->create($favoris);

        return $this->redirectToRoute('read_ressource', [
            'id' => $ressource->getId(),
        ]);
    }

    public function delete(int $idRessource): Response
    {
        $favoris = new Favoris();
        $ressource = $this->ressourceRepository->findOneById($idRessource);

        $favoris->setCreateur($this->security->getUser());
        $favoris->setRessouce($ressource);

        $this->manager->delete($favoris);

        return $this->redirectToRoute('read_ressource', [
            'id' => $ressource->getId(),
        ]);
    }
}