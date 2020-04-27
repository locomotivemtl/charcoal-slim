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
 * Json Route PSR-7 Handler.
 */
class Json
{
    public const DEFAULT_METHODS = ['POST'];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array<string|array|callable>
     */
    private $contexts;

    /**
     * @var ClassResolver
     */
    private $resolver;

    /**
     * @param ContainerInterface $container PSR-11 DI Container.
     */
    public function __construct(ContainerInterface $container)
    {
        // Keep a copy of the container to instantiate the data controller
        $this->container = $container;
        $this->contexts = $container->get('app/contexts');
        $this->resolver = new ClassResolver();
    }

    /**
     * @param Request $request A PSR-7 compatible Request instance.
     * @param Response $response A PSR-7 compatible Response instance.
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $config = new JsonConfig($request->getAttribute('routeDefinition'));
        $request = $request->withoutAttribute('routeDefinition');

        $dataController = $this->getControllerFromConfig($config);

        if (is_string($dataController)) {
            $dataController = new $dataController($this->container);
            $context = $dataController($request, $response);
        } elseif (is_array($dataController)) {
            $context = $dataController;
        } else {
            $context = $dataController($request, $response);
        }

        $response->getBody()->write(json_encode($context));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param JsonConfig $config
     * @return array|mixed|string
     */
    private function getControllerFromConfig(JsonConfig $config)
    {
        if ($config->has('controller')) {
            if (isset($this->contexts[$config->get('controller')])) {
                $dataController = $this->contexts[$config->get('controller')];
            } else {
                $dataController = $this->resolver->resolve($config->get('controller'));
            }
        } else {
            $dataController = [];
        }

        return $dataController;
    }
}
