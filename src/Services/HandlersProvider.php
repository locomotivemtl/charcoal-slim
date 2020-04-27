<?php

declare(strict_types=1);

namespace Charcoal\Slim\Services;

// From 'pimple/pimple'
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Charcoal\Slim\Handlers\{
    Controller,
    Json,
    Proxy,
    Redirection,
    View
};

/**
 *
 */
class HandlersProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container['app/handlers'] = function (): array {
            return [
                'controller' => Controller::class,
                'json' => Json::class,
                'proxy' => Proxy::class,
                'redirection' => Redirection::class,
                'view' => View::class
            ];
        };
    }
}
