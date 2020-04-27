<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

// From 'psr/http-message' (PSR-7)
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// From 'psr/container' (PSR-11)
use Psr\Container\ContainerInterface;
// From 'guzzlehttp/guzzle'
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

/**
 * Proxy Route Handler.
 */
class Proxy
{
    public const DEFAULT_METHODS = ['GET', 'POST'];

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ContainerInterface $container PSR-11 DI Container.
     */
    public function __construct(ContainerInterface $container)
    {
        if ($container->has('app/http-client')) {
            $this->client = $container->get('app/http-client');
        } else {
            $this->client = new Client();
        }
    }

    /**
     * @param Request $request A PSR-7 compatible Request instance.
     * @param Response $response A PSR-7 compatible Response instance.
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $config = new ProxyConfig($request->getAttribute('routeDefinition'));
        $request = $request->withoutAttribute('routeDefinition');

        $method = $config->has('proxyMethod') ? $config->get('proxyMethod') : $request->getMethod();
        $target = new GuzzleRequest($method, $config->get('url'));

        $proxy = $this->client->send($target, $config->get('requestOptions'));
        return $response->withBody($proxy->getBody());
    }
}
