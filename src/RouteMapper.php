<?php

declare(strict_types=1);

namespace Charcoal\Slim;

// From 'psr/http-message' (PSR-7)
use Psr\Http\Message\ServerRequestInterface as Request;
// From 'psr/http-server-handler' (PSR-15)
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
// From 'slim/slim'
use Slim\App;

/**
 * Maps routes on a Slim App to Handler, by type.
 *
 * To map a "type" (ex: "view") to a proper class, maps must be set on the App's container (in `app/handlers`).
 * This will add the routeDefinition and its options as attribute to the request so they can be used in the Handler.
 */
class RouteMapper
{
    private const DEFAULT_TYPE = 'controller';

    /**
     * @param App $app Slim 4 application.
     * @param array<string,array> $definitions Route definitions.
     * @return void
     */
    public function __invoke(App $app, array $definitions): void
    {
        $container = $app->getContainer();
        if ($container === null) {
            return;
        }
        $handlers = $container->get('app/handlers');

        foreach ($definitions as $ident => $routeDefinition) {
            $type = isset($routeDefinition['type']) ? $routeDefinition['type'] : self::DEFAULT_TYPE;

            $handlerClass = $handlers[$type];
            if (!isset($routeDefinition['methods'])) {
                $routeDefinition['methods'] = constant($handlerClass . '::DEFAULT_METHODS');
            }
            if (!isset($routeDefinition['route'])) {
                $routeDefinition['route'] = '/' . ltrim($ident, '/');
            }
            $app->map($routeDefinition['methods'], $routeDefinition['route'], $handlerClass)
                ->setName($ident)
                ->add(
                    function (Request $request, RequestHandler $handler) use ($routeDefinition) {
                        $options = isset($routeDefinition['options']) ? $routeDefinition['options'] : [];
                        return $handler->handle(
                            $request
                                ->withAttribute('routeDefinition', $routeDefinition)
                                ->withAttribute('options', $options)
                        );
                    }
                );
        }
    }
}
