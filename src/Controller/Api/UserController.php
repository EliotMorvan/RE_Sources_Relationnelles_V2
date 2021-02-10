<?php

namespace Controller\Api;

use Entity\User;
use Exception\NotFoundHttpException;
use Http\JsonResponse;
use Http\Response;
use Manager\UserManager;
use Repository\UserRepository;
use Validator\UserValidator;

class UserController
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
        $users = $this->repository->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = $this->normalize($user);
        }

        return new JsonResponse($data);
    }

    public function create(): Response
    {
        $user = new User();

        if (isset($_POST['email'])) {
            $user->setEmail($_POST['email']);
        }
        if (isset($_POST['password'])) {
            $user->setPlainPassword($_POST['password']);
        }
        $user->setDroit(0);

        $errors = $this->validator->validate($user);

        if (empty($errors)) {
            $this->manager->insert($user);

            return new JsonResponse($this->normalize($user));
        }

        return new JsonResponse($errors, 400); // 400 = "Bad Request"
    }

    public function read(int $id): Response
    {
        $user = $this->findUser($id);

        return new JsonResponse($this->normalize($user));
    }

    private function findUser(int $id): User
    {
        $user = $this->repository->findOneById($id);

        if (null === $user) {
            throw new NotFoundHttpException("User not found.");
        }

        return $user;
    }

    private function normalize(User $user): array
    {
        return [
            'id'    => $user->getId(),
            'email' => $user->getEmail(),
        ];
    }
}
