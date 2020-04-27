<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

// From 'psr/http-message' (PSR-7)
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// From 'psr/container' (PSR-11)
use Psr\Container\ContainerInterface;
use Charcoal\Slim\Utils\ClassResolver;

/**
 * Controller Route Handler.
 */
class Controller
{
    public const DEFAULT_METHODS = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array<string|callable>
     */
    private $controllers;

    /**
     * @var ClassResolver
     */
    private $resolver;

    /**
     * Create new template route
     *
     * @param ContainerInterface $container PSR-11 DI Container.
     */
    public function __construct(ContainerInterface $container)
    {
        // Keep a copy of the PSR-11 container, to pass it along the sub-controller
        $this->container = $container;
        $this->controllers = $container->get('app/controllers');
        $this->resolver = new ClassResolver();
    }

    /**
     * @param Request $request A PSR-7 compatible Request instance.
     * @param Response $response A PSR-7 compatible Response instance.
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $config = new ControllerConfig($request->getAttribute('routeDefinition'));
        $request = $request->withoutAttribute('routeDefinition');

        if (isset($this->controllers[$config->get('controller')])) {
            $subController = $this->controllers[$config->get('controller')];
        } else {
            $subController = $this->resolver->resolve($config->get('controller'));
        }

        if (is_string($subController)) {
            $subController = new $subController($this->container);
        }

        return $subController($request, $response);
    }
}
