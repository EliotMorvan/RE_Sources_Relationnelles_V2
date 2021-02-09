<?php

// src/Controller/TestController.php

namespace Controller;

use Entity\User;
use Http\Response;
use Twig\Environment;
use Repository\UserRepository;

class TestController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(Environment $twig, UserRepository $repository)
    {
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function index(): Response
    {
        $user = [
            'name' => 'Admin',
            'email' => 'admin@example.org',
        ];

        $user2 = new User();
        $user2->setEmail('bob@mail');

        $content = $this->twig->render('test/index.html.twig', [
            'my_variable' => 'Hello',
            'my_user' => $user,
            'bob_user' => $user2,
        ]);

        return new Response($content);
    }

    public function foo(): Response
    {
        $content = $this->twig->render('test/foo.html.twig');

        return new Response($content);
    }

    public function user(int $id): Response
    {
        $user = $this->repository->findOneById($id);

        $content = $this->twig->render('test/user.html.twig', [
            'my_user' => $user,
        ]);

        return new Response($content);
    }

    public function userList(): Response
    {
        /** @Var User[] */
        $userList = $this->repository->findAll();

        $content = $this->twig->render('test/userList.html.twig', [
            'user_list' => $userList,
        ]);

        return new Response($content);
    }
}
