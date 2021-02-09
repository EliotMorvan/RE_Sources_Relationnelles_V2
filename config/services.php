<?php

use Controller\Admin;
use Controller\Api;
use Controller\AppController;
use Manager\UserManager;
use Phroute\Phroute\RouteCollector;
use Psr\Container\ContainerInterface;
use Repository\UserRepository;
use Router\Router;
use Router\RouterExtension;
use Router\RouterResolver;
use Security\EncoderInterface;
use Security\Md5Encoder;
use Security\Security;
use Security\SecurityExtension;
use Twig\Environment;
use Validator\UserValidator;

use function DI\autowire;

/**
 * Configuration des services.
 *
 * Ici on ne déclare que les services dont les constructeurs requièrent
 * des paramètres, ou des services particuliers.
 *
 * Les autres services (Repository\UserRepository, Manager\UserManager, etc)
 * n'ont pas besoin d'être déclarés : le conteneur de services est capable de
 * les instancier à la demande, en injectant les autres services requis
 * par leurs constructeurs.
 *
 * @see https://php-di.org/doc/
 */
return [
    // Connection à la base de données
    PDO::class                       => function (ContainerInterface $container) {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        return new PDO(
            $container->get('connection.dsn'),
            $container->get('connection.user'),
            $container->get('connection.password'),
            $options
        );
    },

    // Routeur
    /** @see https://github.com/mrjgreen/phroute */
    Router::class                    => function (ContainerInterface $container) {
        // Charge le fichier de configuration des routes
        $collector = new RouteCollector();
        $routes = require $container->get('project_dir') . '/config/routes.php';
        $routes($collector, $container);

        // Permet d'instancier les classes *Controller
        $resolver = new RouterResolver($container);

        return new Router($collector, $resolver);
    },

    // Moteur de templates
    /** @see https://twig.symfony.com/doc/3.x/templates.html */
    Environment::class               => function (ContainerInterface $container) {
        // Permet de charger les fichiers .twig du dossier templates/.
        $loader = new Twig\Loader\FilesystemLoader(
            $container->get('project_dir') . '/templates'
        );

        // Le moteur de template
        $environment = new Environment($loader, [
            'cache' => $container->get('project_dir') . '/cache/twig',
            // Si FALSE (production), le cache ne sera plus réactualisé automatiquement
            'debug' => $container->get('debug'),
        ]);

        // Une extension permettant d'utiliser dans les templates
        // la fonction : path(route_name, parameters)
        // pour générer des URLs d'après les routes configurées
        $environment->addExtension(
            new RouterExtension($container->get(Router::class))
        );

        // Une extension permettant d'utiliser dans les templates
        // la fonction : get_user()
        // qui renvoie l'utilisateur connecté (instance de User).
        /** @see templates/admin/fragment/navbar.html.twig */
        $environment->addExtension(
            new SecurityExtension($container->get(Security::class))
        );

        /** @see https://twig.symfony.com/doc/3.x/advanced.html#filters */
        /** @see https://twig.symfony.com/doc/3.x/advanced.html#functions */

        return $environment;
    },

    // Encodeur de mot de passe
    EncoderInterface::class          => function () {
        return new Md5Encoder();
    },

    // For performances
    /** @see https://php-di.org/doc/performances.html */
    Admin\DashboardController::class => autowire(),
    Admin\SecurityController::class  => autowire(),
    Admin\UserController::class      => autowire(),
    Api\UserController::class        => autowire(),
    AppController::class             => autowire(),
    UserManager::class               => autowire(),
    UserRepository::class            => autowire(),
    UserValidator::class             => autowire(),
];
