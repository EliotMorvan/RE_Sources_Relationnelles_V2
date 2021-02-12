<?php

// src/Controller/RessourceController.php

namespace Controller;

use Entity\User;
use Entity\Ressource;
use Exception\NotFoundHttpException;
use Http\Response;
use Twig\Environment;
use Repository\RessourceRepository;
use Manager\RessourceManager;

class RessourceController extends AbstractController
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

                return $this->redirectToRoute('liste_ressources');
        }

        $content = $this->twig->render('ressource/create.html.twig');
        return new Response($content);
    }

    public function updateRessource(int $id): Response
    {
        $ressource = $this->repository->findOneById($id);

        if (isset($_POST['update_ressource']))
        {
            $ressource
                ->setTitre($_POST['titre'])
                ->setContenu($_POST['contenu']);

            $this->manager->update($ressource);
            return $this->redirectToRoute('liste_ressources');
        }
        
        $content = $this->twig->render('ressource/udate.html.twig', [
            'ressource'   => $ressource,
        ]);
        return new Response($content);
    }

    public function delete(int $id): Response
    {
        $ressource = $this->findRessource($id);

        if (isset($_POST['delete_ressource'])) {
            // Si l'internaute a confirmé
            if ($_POST['confirm'] === '1') {
                $this->manager->delete($ressource);

                return $this->redirectToRoute('liste_ressources');
            }
        }

        return $this->render('ressource/delete.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    private function findRessource(int $id): Ressource
    {
        $ressource = $this->repository->findOneById($id);

        if (null === $ressource) {
            throw new NotFoundHttpException("Ressource not found.");
        }

        return $ressource;
    }
}
