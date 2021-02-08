<?php

use DI\ContainerBuilder;
use Exception\NotFoundHttpException;
use Http\Request;
use Http\Response;
use Psr\Container\ContainerInterface;
use Router\Router;

class Kernel
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var ContainerInterface
     */
    private $container;


    public function __construct(string $projectDir, bool $debug = false)
    {
        $this->projectDir = $projectDir;
        $this->debug = $debug;
    }

    /**
     * Traite la requête.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        session_start();

        $this->build();

        $router = $this->container->get(Router::class);

        try {
            $response = $router->match($request);
        } catch (NotFoundHttpException $e) {
            $response = new Response($e->getMessage(), 400);
        }

        if (!$response instanceof Response) {
            throw new LogicException("The controller must return a Response.");
        }

        return $response;
    }

    /**
     * Construit le conteneur de services.
     *
     * @see https://php-di.org/doc/
     */
    private function build(): void
    {
        $builder = new ContainerBuilder();

        // Configure les paramètres de base.
        $builder->addDefinitions([
            'debug'       => $this->debug,
            'project_dir' => $this->projectDir,
        ]);

        // Charge le fichier de paramètres
        $path = $this->projectDir . '/config/parameters.php';
        if (!file_exists($path)) {
            throw new Exception(
                "Please create the 'config/parameters.php' file, ".
                "based on 'config/parameters.php.dist'."
            );
        }
        $builder->addDefinitions(require $path);

        // Charge le fichier de configuration des services.
        $builder->addDefinitions(require $this->projectDir . '/config/services.php');

        $this->container = $builder->build();
    }
}
