<?php

namespace Controller;

use Http\RedirectResponse;
use Http\Response;
use Router\Router;
use Twig\Environment;

/**
 * Class AbstractController
 * @package Controller
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Router
     */
    private $router;

    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    /**
     * Renders the template.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return Response
     */
    protected function render(string $name, array $parameters = []): Response
    {
        $content = $this->twig->render($name, $parameters);

        return new Response($content);
    }

    /**
     * Generates the url.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return string
     */
    protected function generate(string $name, array $parameters): string
    {
        return $this->router->generate($name, $parameters);
    }

    /**
     * Redirects to the given path.
     *
     * @param string $path
     *
     * @return RedirectResponse
     */
    protected function redirect(string $path): RedirectResponse
    {
        return new RedirectResponse($path);
    }

    /**
     * Redirects to the given route.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return RedirectResponse
     */
    protected function redirectToRoute(string $name, array $parameters = []): RedirectResponse
    {
        return $this->redirect($this->generate($name, $parameters));
    }
}
