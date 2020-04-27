<?php

namespace Charcoal\Slim\Handlers;

use Charcoal\Config\GenericConfig;

class JsonConfig extends GenericConfig
{
    /**
     * @var string
     */
    protected $ident;

    /**
     * @var string
     */
    protected $controller;

    public function getController(): string
    {
        if (!$this->controller) {
            return $this->get('ident');
        }
        return $this->controller;
    }
}
