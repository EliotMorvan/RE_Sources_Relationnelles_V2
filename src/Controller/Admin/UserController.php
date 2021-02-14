<?php

namespace Controller\Admin;

use Controller\AbstractController;
use Entity\User;
use Exception\NotFoundHttpException;
use Http\Response;
use Manager\UserManager;
use Repository\UserRepository;
use Validator\UserValidator;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var UserManager
     */
    private $manager;

    /**
     * @var UserValidator
     */
    private $validator;


    public function __construct(
        UserRepository $repository,
        UserManager $manager,
        UserValidator $validator
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $this->repository->findAll(),
        ]);
    }

    public function create(): Response
    {
        $user = new User();
        $errors = [];

        if (isset($_POST['create_user'])) {
            $user
                ->setEmail($_POST['email'])
                ->setPlainPassword($_POST['password'])
                ->setDroit($_POST['droit']);

            $errors = $this->validator->validate($user);

            if (empty($errors)) {
                $this->manager->insert($user);

                return $this->redirectToRoute('admin_user_index');
            }
        }

        return $this->render('admin/user/create.html.twig', [
            'user'   => $user,
            'errors' => $errors,
        ]);
    }

    public function read(int $id): Response
    {
        $user = $this->findUser($id);

        return $this->render('admin/user/read.html.twig', [
            'user' => $user,
        ]);
    }

    public function update(int $id): Response
    {
        $user = $this->findUser($id);

        $errors = [];

        if (isset($_POST['update_user'])) {
            $user
                ->setEmail($_POST['email'])
                ->setPlainPassword($_POST['password'])
                ->setDroit($_POST['droit']);

            $errors = $this->validator->validate($user);

            if (empty($errors)) {
                $this->manager->update($user);

                return $this->redirectToRoute('admin_user_index');
            }
        }

        return $this->render('admin/user/update.html.twig', [
            'user'   => $user,
            'errors' => $errors,
        ]);
    }

    public function delete(int $id): Response
    {
        $user = $this->findUser($id);

        if (isset($_POST['delete_user'])) {
            // Si l'internaute a confirmé
            if ($_POST['confirm'] === '1') {
                $this->manager->remove($user);

                return $this->redirectToRoute('admin_user_index');
            }
        }

        return $this->render('admin/user/delete.html.twig', [
            'user' => $user,
        ]);
    }

    private function findUser(int $id): User
    {
        $user = $this->repository->findOneById($id);

        if (null === $user) {
            throw new NotFoundHttpException("User not found.");
        }

        return $user;
    }
}
