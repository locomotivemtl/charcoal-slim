<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

use Charcoal\Config\AbstractConfig;

class ProxyConfig extends AbstractConfig
{
    /**
     * @var string
     */
    protected $url;

    /**
     * Guzzle client request options
     * @var array<mixed>
     * @see http://docs.guzzlephp.org/en/latest/request-options.html
     */
    protected $requestOptions = [];

    /**
     * @var string
     */
    protected $proxyMethod;
}
