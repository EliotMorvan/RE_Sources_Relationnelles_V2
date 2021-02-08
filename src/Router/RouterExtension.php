<?php

namespace Router;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterExtension extends AbstractExtension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('path', function(string $name, array $parameters = []) {
                return $this->router->generate($name, $parameters);
            }),
        ];
    }
}
