<?php

use Controller\Admin;
use Controller\Api;
use Controller\AppController;
use Controller\TestController;
use Controller\RessourceController;
use Http\RedirectResponse;
use Phroute\Phroute\RouteCollector;
use Psr\Container\ContainerInterface;
use Router\Router;
use Security\Security;

/**
 * Configuration des routes.
 *
 * @see https://github.com/mrjgreen/phroute
 */
return function (RouteCollector $router, ContainerInterface $container) {
    // Filtre de sécurisation
    $router->filter('secured', function () use ($container) {
        // Si l'utilisateur est pas authentifié
        if ($container->get(Security::class)->getUser()) {
            // On renvoi null pour exécuter le contrôleur
            return null;
        }

        // Redirige vers la page de login
        // 403 : Code HTTP pour "accès non autorisé" (Access Denied)
        $path = $container->get(Router::class)->generate('admin_login');

        return new RedirectResponse($path, 403);
    });

    // --------- Partie publique ---------

    // Page d'accueil
    $router->get(
        // Url, Name
        ['/', 'app_index'],
        // Class, Method
        [AppController::class, 'index']
    );

    $router->get(
        ['/test', 'test_index'], 
        [TestController::class, 'index']
    );
    
    $router->get(
        ['/test/foo', 'test_foo'], 
        [TestController::class, 'foo']
    );

    $router->get(
        ['/test/user/{id}', 'test_user'],
        [TestController::class, 'user']
    );

    $router->get(
        ['/test/userList', 'test_user_list'],
        [TestController::class, 'userList']
    );

    // Gestion des ressources
    $router->get(
        ['/ressources', 'liste_ressources'],
        [RessourceController::class, 'index']
    );

    $router->any(
        ['ressources/creation', 'create_ressource'],
        [RessourceController::class, 'createRessource']
    );

    // --------- API ---------

    // Gestion des utilisateurs
    $router->group(
        [
            'prefix' => '/api/user',
            // TODO 'before' => 'secured',
        ],
        function ($router) {
            $router->get(
                ['/', 'api_user_index'],
                [Api\UserController::class, 'index']
            );

            $router->post(
                ['/', 'api_user_create'],
                [Api\UserController::class, 'create']
            );

            $router->get(
                ['/{id:\d+}', 'api_user_read'],
                [Api\UserController::class, 'read']
            );

            // ...
        }
    );

    // --------- Administration ---------

    // Connexion
    $router->any(
        ['/admin/login', 'admin_login'],
        [Admin\SecurityController::class, 'login']
    );

    // Déconnexion
    $router->get(
        ['/admin/logout', 'admin_logout'],
        [Admin\SecurityController::class, 'logout']
    );

    // Tableau de bord
    $router->get(
        ['/admin', 'admin_dashboard'],
        [Admin\DashboardController::class, 'index'],
        ['before' => 'secured']
    );

    // Gestion des utilisateurs
    $router->group(
        [
            'prefix' => '/admin/user',
            'before' => 'secured',
        ],
        function ($router) {
            $router->get(
                ['/', 'admin_user_index'],
                [Admin\UserController::class, 'index']
            );

            $router->any(
                ['/create', 'admin_user_create'],
                [Admin\UserController::class, 'create']
            );

            $router->get(
                ['/read/{id:\d+}', 'admin_user_read'],
                [Admin\UserController::class, 'read']
            );

            $router->any(
                ['/update/{id:\d+}', 'admin_user_update'],
                [Admin\UserController::class, 'update']
            );

            $router->any(
                ['/delete/{id:\d+}', 'admin_user_delete'],
                [Admin\UserController::class, 'delete']
            );
        }
    );

};
