<?php

namespace Controller\Admin;

use Controller\AbstractController;
use Entity\CategorieRessource;
use Exception\NotFoundHttpException;
use Http\Response;
use Manager\CategorieRessourceManager;
use Repository\CategorieRessourceRepository;

class CategorieRessourceController extends AbstractController
{
    /**
     * @var CategorieRessourceRepository
     */
    private $repository;

    /**
     * @var CategorieRessourceManager
     */
    private $manager;

    /**
     * @var CategorieRessourceValidator
     */
    private $validator;


    public function __construct(
        CategorieRessourceRepository $repository,
        CategorieRessourceManager $manager
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function index(): Response
    {
        return $this->render('admin/categorieRessource/index.html.twig', [
            'categories' => $this->repository->findAll(),
        ]);
    }

    public function create(): Response
    {
        $categorie = new CategorieRessource();

        if (isset($_POST['create_categorie'])) {
            $categorie
                ->setNom($_POST['nom']);

            $this->manager->insert($categorie);
            return $this->redirectToRoute('admin_categorie_ressource_index');
        }

        return $this->render('admin/categorieRessource/create.html.twig', [
            'categorie'   => $categorie,
        ]);
    }

    public function read(int $id): Response
    {
        $categorie = $this->findCategorie($id);

        return $this->render('admin/categorieRessource/read.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    public function update(int $id): Response
    {
        $categorie = $this->findCategorie($id);

        $errors = [];

        if (isset($_POST['update_categorie'])) {
            $categorie
                ->setNom($_POST['nom']);

            $this->manager->update($categorie);
            return $this->redirectToRoute('admin_categorie_ressource_index');
        }

        return $this->render('admin/categorieRessource/update.html.twig', [
            'categorie'   => $categorie,
            'errors' => $errors,
        ]);
    }

    public function delete(int $id): Response
    {
        $categorie = $this->findCategorie($id);

        if (isset($_POST['delete_categorie'])) {
            // Si l'internaute a confirmé
            if ($_POST['confirm'] === '1') {
                $this->manager->remove($categorie);

                return $this->redirectToRoute('admin_categorie_ressource_index');
            }
        }

        return $this->render('admin/categorieRessource/delete.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    private function findCategorie(int $id): CategorieRessource
    {
        $categorie = $this->repository->findOneById($id);

        if (null === $categorie) {
            throw new NotFoundHttpException("Categorie introuvable.");
        }

        return $categorie;
    }
}
