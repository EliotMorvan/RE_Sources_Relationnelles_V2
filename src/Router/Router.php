<?php

namespace Router;

use Http\Request;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

class Router
{
    /**
     * @var RouteCollector
     */
    private $collector;

    /**
     * @var RouterResolver
     */
    private $resolver;


    public function __construct(RouteCollector $collector, RouterResolver $resolver)
    {
        $this->collector = $collector;
        $this->resolver = $resolver;
    }

    public function match(Request $request)
    {
        $dispatcher = new Dispatcher($this->collector->getData(), $this->resolver);

        return $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath()
        );
    }

    public function generate(string $name, array $parameters = []): string
    {
        return '/' . $this->collector->route($name, $parameters);
    }
}
