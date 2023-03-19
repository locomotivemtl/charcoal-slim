<?php

declare(strict_types=1);

namespace Charcoal\Slim;

use Charcoal\Slim\Exceptions\RouteException;
use Charcoal\Slim\Handlers\{
    Controller,
    Json,
    Proxy,
    Redirection,
    View
};
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

/**
 * Maps routes on a Slim App to PSR-15 Handler, by type.
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
        $handlersMap = $this->getHandlersFromApp($app);

        foreach ($definitions as $routeDefinition) {
            if (!isset($routeDefinition['route'])) {
                throw new RouteException(
                    'Route undefined.'
                );
            }
            $type = $routeDefinition['type'] ?? self::DEFAULT_TYPE;

            if (!isset($handlersMap[$type])) {
                throw new RouteException(
                    sprintf('Invalid route type "%s".', (string)$type)
                );
            }

            $handlerClass = $handlersMap[$type];
            if (!isset($routeDefinition['methods'])) {
                $routeDefinition['methods'] = constant($handlerClass . '::DEFAULT_METHODS');
            }
            $app->map($routeDefinition['methods'], $routeDefinition['route'], $handlerClass)
                ->add(
                    function (Request $request, RequestHandler $handler) use ($routeDefinition) {
                        $options = $routeDefinition['options'] ?? [];
                        return $handler->handle(
                            $request
                                ->withAttribute('routeDefinition', $routeDefinition)
                                ->withAttribute('options', $options)
                        );
                    }
                );
        }
    }

    private function getHandlersFromApp(App $app): array
    {
        if ($app->getContainer()->has('app/handlers')) {
            return array_merge(
                $this->defaultHandlers(),
                $app->getContainer()->get('app/handlers')
            );
        } else {
            return $this->defaultHandlers();
        }
    }

    private function defaultHandlers(): array
    {
        return [
            'controller' => Controller::class,
            'json' => Json::class,
            'proxy' => Proxy::class,
            'redirection' => Redirection::class,
            'view' => View::class
        ];
    }
}
