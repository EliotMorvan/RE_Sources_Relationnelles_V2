<?php

use Controller\Admin\DashboardController;
use Controller\Admin\SecurityController;
use Controller\Admin\UserController;
use Controller\AppController;
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
    // --------- Partie publique ---------

    // Page d'accueil
    $router->any(
        // Url, Name
        ['/', 'app_index'],
        // Class, Method
        [AppController::class, 'index']
    );

    // --------- Administration ---------

    // Connexion
    $router->any(
        ['/admin/login', 'admin_login'],
        [SecurityController::class, 'login']
    );

    // Déconnexion
    $router->get(
        ['/admin/logout', 'admin_logout'],
        [SecurityController::class, 'logout']
    );

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

    // Tableau de bord
    $router->get(
        ['/admin', 'admin_dashboard'],
        [DashboardController::class, 'index'],
        ['before' => 'secured']
    );

    // Gestion des utilisateurs
    $router->group(
        [
            'prefix' => '/admin/user',
            'before' => 'secured'
        ],
        function ($router) {
            $router->get(
                ['/', 'admin_user_index'],
                [UserController::class, 'index']
            );

            $router->any(
                ['/create', 'admin_user_create'],
                [UserController::class, 'create']
            );

            $router->get(
                ['/read/{id:\d+}', 'admin_user_read'],
                [UserController::class, 'read']
            );

            $router->any(
                ['/update/{id:\d+}', 'admin_user_update'],
                [UserController::class, 'update']
            );

            $router->any(
                ['/delete/{id:\d+}', 'admin_user_delete'],
                [UserController::class, 'delete']
            );
        }
    );
};
