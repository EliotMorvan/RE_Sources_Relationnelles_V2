<?php

// src/Controller/RessourceController.php

namespace Controller;

use DateTime;
use Entity\CategorieRessource;
use Entity\Commentaire;
use Entity\User;
use Entity\Ressource;
use Entity\TypeRessource;
use Exception\NotFoundHttpException;
use Http\Response;
use Twig\Environment;
use Repository\RessourceRepository;
use Repository\CategorieRessourceRepository;
use Manager\RessourceManager;
use Security\Security;

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

    /**
     * @var CategorieRessourceRepository
     */
    private $categorieRessourceRepository;

    /**
     * @var Securiry
     */
    private $security;

    public function __construct(
        Environment $twig, 
        RessourceRepository $repository,
        CategorieRessourceRepository $categorieRessourceRepository,
        RessourceManager $manager,
        Security $security)
    {
        $this->twig = $twig;
        $this->repository = $repository;
        $this->categorieRessourceRepository = $categorieRessourceRepository;
        $this->manager = $manager;
        $this->security = $security;
    }

    public function index(): Response
    {
        $ressources = $this->repository->findAll();
        $content = $this->twig->render('ressource/index.html.twig', [
            'ressources' => $ressources,
        ]);

        return new Response($content);
    }

    public function indexReg(string $reg): Response
    {
        $ressources = $this->repository->findAllForReg($reg);
        $content = $this->twig->render('ressource/index.html.twig', [
            'reg'        => $reg,
            'ressources' => $ressources,
        ]);
        return new Response($content);
    }

    public function createRessource(): Response
    {
        $ressource = new Ressource();

        // Récup du créateur
        $createur = $this->security->getUser();

        // Récup de la liste des catégories, des types
        $categories = $this->categorieRessourceRepository->findAll();
        $types = TypeRessource::types;

        if (isset($_POST['create_ressource'])) {
            // Récup de la catégorie depuis l'id sélectionné
            $categorie = $this->categorieRessourceRepository->findOneById($_POST['categorie']);

            $ressource
                ->setTitre($_POST['titre'])
                ->setContenu($_POST['contenu'])
                ->setCreateur($createur)
                ->setCategorie($categorie)
                ->setType($_POST['type']);

                $this->manager->insert($ressource);

                return $this->redirectToRoute('liste_ressources');
        }

        $content = $this->twig->render('ressource/create.html.twig', [
            'categories'  => $categories,
            'types'       => $types,
        ]);
        return new Response($content);
    }

    public function updateRessource(int $id): Response
    {
        // Récup de la ressource à modifier
        $ressource = $this->repository->findOneById($id);

        // Récup de la liste des catégories, des types
        $categories = $this->categorieRessourceRepository->findAll();
        $types = TypeRessource::types;

        if (isset($_POST['update_ressource']))
        {
            $categorie = $this->categorieRessourceRepository->findOneById($_POST['categorie']);
            $ressource
                ->setTitre($_POST['titre'])
                ->setContenu($_POST['contenu'])
                ->setCategorie($categorie)
                ->setType($_POST['type']);

            $this->manager->update($ressource);
            return $this->redirectToRoute('liste_ressources');
        }
        
        $content = $this->twig->render('ressource/udate.html.twig', [
            'ressource'   => $ressource,
            'categories'  => $categories,
            'types'       => $types,
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

    public function deleteCommentaire(int $id): Response
    {
        $commentaire = $this->findCommentaire($id);

        if (isset($_POST['delete_commentaire'])) {
            // Si l'internaute a confirmé
            if ($_POST['confirm'] === '1') {
                $this->manager->deleteCommentaire($commentaire->getId());

                return $this->redirectToRoute('liste_ressources');
            }
        }

        return $this->render('ressource/commentaires/delete.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    public function read(int $id): Response {
        $ressource = $this->findRessource($id);

        if (isset($_POST['poster_commentaire']))
        {
            // Récup du créateur
            $createur = $this->security->getUser();

            $commentaire = new Commentaire();
            $commentaire->setContenu($_POST['commentaire'])
                ->setCreateur($createur)
                ->setRessource($ressource);

            $this->manager->posterCommentaire($commentaire, $ressource, $createur);
            return $this->redirectToRoute('liste_ressources');
        }

        return $this->render('ressource/read.html.twig', [
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

    private function findCommentaire(int $id): Commentaire
    {
        $commentaire = $this->repository->findOneCommentaireById($id);

        if (null === $commentaire) {
            throw new NotFoundHttpException("Commentaire introuvable.");
        }

        return $commentaire;
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}
