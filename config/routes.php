<?php

use Controller\Admin;
use Controller\Api;
use Controller\AppController;
use Controller\CategorieRessourceController;
use Controller\FavorisController;
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
    $router->filter('citoyen', function () use ($container) {
        // Si l'utilisateur est pas authentifié
        if ($container->get(Security::class)->isConnected()) {
            // On renvoi null pour exécuter le contrôleur
            return null;
        }

        // Redirige vers la page de login
        // 403 : Code HTTP pour "accès non autorisé" (Access Denied)
        $path = $container->get(Router::class)->generate('admin_login');

        return new RedirectResponse($path, 403);
    });

    $router->filter('moderateur', function () use ($container) {
        // Si l'utilisateur est pas authentifié
        if ($container->get(Security::class)->isModerateur()) {
            // On renvoi null pour exécuter le contrôleur
            return null;
        }

        // Redirige vers la page de login
        // 403 : Code HTTP pour "accès non autorisé" (Access Denied)
        $path = $container->get(Router::class)->generate('app_index');

        return new RedirectResponse($path, 403);
    });

    $router->filter('administrateur', function () use ($container) {
        // Si l'utilisateur est pas authentifié
        if ($container->get(Security::class)->isAdministrateur()) {
            // On renvoi null pour exécuter le contrôleur
            return null;
        }

        // Redirige vers la page de login
        // 403 : Code HTTP pour "accès non autorisé" (Access Denied)
        $path = $container->get(Router::class)->generate('app_index');

        return new RedirectResponse($path, 403);
    });

    $router->filter('superAdministrateur', function () use ($container) {
        // Si l'utilisateur est pas authentifié
        if ($container->get(Security::class)->isSuperAdministrateur()) {
            // On renvoi null pour exécuter le contrôleur
            return null;
        }

        // Redirige vers la page de login
        // 403 : Code HTTP pour "accès non autorisé" (Access Denied)
        $path = $container->get(Router::class)->generate('app_index');

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

    // ---------- Gestion des ressources ----------
    $router->get(
        ['/ressources', 'liste_ressources'],
        [RessourceController::class, 'index']
    );

    $router->get(
        ['/ressources/{reg}', 'liste_ressources_reg'],
        [RessourceController::class, 'indexReg']
    );

    $router->any(
        ['ressources/creation', 'create_ressource'],
        [RessourceController::class, 'createRessource']
    );

    $router->any(
        ['ressources/update/{id}', 'update_ressource'],
        [RessourceController::class, 'updateRessource']
    );

    $router->any(
        ['ressources/delete/{id}', 'delete_ressource'],
        [RessourceController::class, 'delete']
    );

    $router->any(
        ['ressources/read/{id}', 'read_ressource'],
        [RessourceController::class, 'read']
    );
// ---------- Gestion des favoris ----------
$router->get(
    ['/favoris', 'liste_favoris'],
    [FavorisController::class, 'index']
);

    $router->any(
        ['ressources/commentaires/delete/{id}', 'delete_commentaire'],
        [RessourceController::class, 'deleteCommentaire']
    );

    // --------- Catégories de ressource ---------

    $router->get(
        ['/categories/liste', 'liste_categorie_ressource'],
        [CategorieRessourceController::class, 'liste']
    );
    
    $router->get(
        ['/categorie/{id}', 'categorie_ressource'],
        [CategorieRessourceController::class, 'index']
    );

    // --------- Types de ressource ---------

    $router->get(
        ['/types/liste', 'liste_type_ressource'],
        [CategorieRessourceController::class, 'listeType']
    );
    
    $router->get(
        ['/type/{nom}', 'type_ressource'],
        [CategorieRessourceController::class, 'indexType']
    );

    // --------- Types de ressource ---------

    $router->get(
        ['/favoris/create/{id}', 'create_favoris'],
        [FavorisController::class, 'create']
    );

    $router->get(
        ['/favoris/delete/{id}', 'delete_favoris'],
        [FavorisController::class, 'delete']
    );

    // --------- API ---------

    // Gestion des utilisateurs
    $router->group(
        [
            'prefix' => '/api/user',
            'before' => 'administrateur',
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
        ['before' => 'administrateur']
    );

    // Gestion des utilisateurs
    $router->group(
        [
            'prefix' => '/admin/user',
            'before' => 'administrateur',
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

    // Gestion des catégories de ressource
    $router->group(
        [
            'prefix' => '/admin/categorie',
            'before' => 'administrateur',
        ],
        function ($router) {
            $router->get(
                ['/', 'admin_categorie_ressource_index'],
                [Admin\CategorieRessourceController::class, 'index']
            );

            $router->any(
                ['/create', 'admin_categorie_ressource_create'],
                [Admin\CategorieRessourceController::class, 'create']
            );

            $router->get(
                ['/read/{id:\d+}', 'admin_categorie_ressource_read'],
                [Admin\CategorieRessourceController::class, 'read']
            );

            $router->any(
                ['/update/{id:\d+}', 'admin_categorie_ressource_update'],
                [Admin\CategorieRessourceController::class, 'update']
            );

            $router->any(
                ['/delete/{id:\d+}', 'admin_categorie_ressource_delete'],
                [Admin\CategorieRessourceController::class, 'delete']
            );
        }
    );

};
