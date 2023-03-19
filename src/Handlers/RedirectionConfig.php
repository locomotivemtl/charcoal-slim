<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

use Charcoal\Config\AbstractConfig;

class RedirectionConfig extends AbstractConfig
{
    protected string $target;


    protected int $code = 302;
}
