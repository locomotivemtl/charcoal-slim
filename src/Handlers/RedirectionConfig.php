<?php

declare(strict_types=1);

namespace Charcoal\Slim\Handlers;

use Charcoal\Config\GenericConfig;

class RedirectionConfig extends GenericConfig
{
    /**
     * @var string
     */
    protected $ident;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var int
     */
    protected $code = 302;
}
