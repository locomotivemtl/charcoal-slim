<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

use Charcoal\Config\AbstractConfig;

class RedirectionConfig extends AbstractConfig
{
    /**
     * @var string
     */
    protected $target;

    /**
     * @var int
     */
    protected $code = 302;
}
