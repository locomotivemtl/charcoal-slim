<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

// From 'psr/http-message' (PSR-7)
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Redirection Route Handler.
 */
class Redirection
{
    public const DEFAULT_METHODS = ['GET'];

    /**
     * @param Request $request A PSR-7 compatible Request instance.
     * @param Response $response A PSR-7 compatible Response instance.
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $config = new RedirectionConfig($request->getAttribute('routeDefinition'));

        return $response
            ->withHeader('Location', $config->get('target'))
            ->withStatus($config->get('code'));
    }
}
