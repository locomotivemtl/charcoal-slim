<?php

namespace Charcoal\Slim\Handlers;

use Charcoal\Config\GenericConfig;

class ViewConfig extends GenericConfig
{
    /**
     * @var string
     */
    protected $controller;

    /**
     * The view engine to use to load and render the template.
     * @var string
     */
    protected $engine;

    /**
     * @var string
     */
    protected $ident;

    /**
     * The template to render.
     * @var string|null
     */
    protected $template;


    /**
     * @return string
     */
    public function getTemplate(): string
    {
        if (!$this->template) {
            return $this->get('ident');
        }
        return $this->template;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        if (!$this->controller) {
            return $this->get('template');
        }
        return $this->controller;
    }
}
