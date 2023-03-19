<?php

declare(strict_types=1);

namespace Charcoal\Slim\Services;

use Pimple\{
    Container,
    ServiceProviderInterface
};

/**
 *
 */
class ControllersProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        /**
         *
         */
        $container['app/controllers'] = function (): array {
            return [];
        };

        /**
         * Holds the various contexts for JSON handlers as well as view controllers.
         *
         * Can be just a string as FQN of the context controller class or callable or an instance of the class itself.
         * The PSR-11 container will be passed to the class constructor. Required callback signature:
         * ```php
         * use Psr\Http\Message\ServerRequestInterface as Request;
         * use Psr\Http\Message\ResponseInterface as Response;
         *
         * public function __invoke(Request $request, Response $response) : array;
         * ```
         *
         */
        $container['app/contexts'] = function (): array {
            return [];
        };
    }
}
