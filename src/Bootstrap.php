<?php

declare(strict_types=1);

namespace Charcoal\Slim;

use Charcoal\Config\ConfigInterface;
use Charcoal\Config\GenericConfig as Config;
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;
use Slim\App;
use Slim\Factory\AppFactory;


/**
 * Bootstrap a Slim 4 App
 */
class Bootstrap
{
    private Container $container;

    /**
     * @var callable[]
     */
    private array $configCallbacks = [];

    /**
     * @var callable[]
     */
    private array $containerCallbacks = [];

    /**
     * @var callable[]
     */
    private array $bootstrapCallbacks = [];

    /**
     * @var callable[]
     */
    private array $appCallbacks = [];


    public function __construct(?ConfigInterface $config = null)
    {
        $this->container = new Container(
            [
                'config' => ($config ?: new Config())
            ]
        );
    }

    public function __invoke(): App
    {
        while ($configCallback = array_shift($this->configCallbacks)) {
            $configCallback($this->container['config']);
        }

        while ($containerCallback = array_shift($this->containerCallbacks)) {
            $containerCallback($this->container);
        }

        while ($bootstrapCallback = array_shift($this->bootstrapCallbacks)) {
            $bootstrapCallback($this);
        }

        $this->container['container/pimple'] = $this->container;
        $this->container['container/psr11'] = new Psr11Container($this->container);
        AppFactory::setContainer($this->container['container/psr11']);
        $app = AppFactory::create();

        // Parse json, form data and xml
        $app->addBodyParsingMiddleware();
        $app->addRoutingMiddleware();


        while ($appCallback = array_shift($this->appCallbacks)) {
            $appCallback($app);
        }

        $logger = ($app->getContainer()->has('logger')) ? $app->getContainer()->get('logger') : null;
        $app->addErrorMiddleware(true, true, true, $logger);

        return $app;
    }

    public function addConfig(callable $callback): void
    {
        $this->configCallbacks[] = $callback;
    }

    public function addBootstrap(callable $callback): void
    {
        $this->bootstrapCallbacks[] = $callback;
    }

    public function addContainer(callable $callback): void
    {
        $this->containerCallbacks[] = $callback;
    }

    public function addApp(callable $callback): void
    {
        $this->appCallbacks[] = $callback;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}
