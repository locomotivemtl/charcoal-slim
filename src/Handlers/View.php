<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

// From 'psr/http-message' (PSR-7)
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// From 'psr/container' (PSR-11)
use Psr\Container\ContainerInterface;
// From 'locomotivemtl/charcoal-view'
use Charcoal\View\Renderer;
use Charcoal\Slim\Utils\ClassResolver;

/**
 * View Route PSR-7 Handler.
 */
class View
{
    public const DEFAULT_METHODS = ['GET'];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array<string|array|callable>
     */
    private $views;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var ClassResolver
     */
    private $resolver;

    /**
     * @param ContainerInterface $container PSR-11 DI Container.
     */
    public function __construct(ContainerInterface $container)
    {
        // Keep a copy of the container to instantiate the view controller
        $this->container = $container;
        $this->views = $container->get('app/contexts');
        $this->renderer = $container->get('view/renderer');
        $this->resolver = new ClassResolver();
    }

    /**
     * @param Request $request A PSR-7 compatible Request instance.
     * @param Response $response A PSR-7 compatible Response instance.
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $config = new ViewConfig($request->getAttribute('routeDefinition'));
        $request = $request->withoutAttribute('routeDefinition');

        $viewController = $this->getControllerFromConfig($config);

        if (is_string($viewController)) {
            $viewController = new $viewController($this->container);
            $context = $viewController($request, $response);
        } elseif (is_array($viewController)) {
            $context = $viewController;
        } elseif (is_callable($viewController)) {
            $context = $viewController($request, $response);
        } else {
            $context = [];
        }

        return $this->renderer->render($response, $config->get('template'), $context);
    }

    /**
     * @param ViewConfig $config
     * @return array|mixed|string
     */
    private function getControllerFromConfig(ViewConfig $config)
    {
        if ($config->has('controller')) {
            $controller = $config->get('controller');
            if (isset($this->views[$controller])) {
                $viewController = $this->views[$controller];
            } else {
                $viewController = $this->resolver->resolve($controller);
            }
        } else {
            $viewController = [];
        }

        return $viewController;
    }
}
