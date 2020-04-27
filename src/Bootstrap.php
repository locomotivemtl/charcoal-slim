<?php

declare(strict_types=1);

namespace Charcoal\Slim;

// From 'slim/slim'
use Slim\App;
use Slim\Factory\AppFactory;
// From 'pimple/pimple'
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;
// From 'locomotivemtl/charcoal-config'
use Charcoal\Config\ConfigInterface;
use Charcoal\Config\GenericConfig as Config;

/**
 * Bootstrap a Slim 4 App
 */
class Bootstrap
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var callable[]
     */
    private $configCallbacks = [];

    /**
     * @var callable[]
     */
    private $containerCallbacks = [];

    /**
     * @var callable[]
     */
    private $bootstrapCallbacks = [];

    /**
     * @var callable[]
     */
    private $appCallbacks = [];

    /**
     * @param ConfigInterface|null $config
     */
    public function __construct(?ConfigInterface $config = null)
    {
        $this->container = new Container(
            [
                'config' => ($config ?: new Config())
            ]
        );
    }

    /**
     * @return App
     */
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

    /**
     * @param callable $callback
     * @return void
     */
    public function addConfig(callable $callback): void
    {
        $this->configCallbacks[] = $callback;
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function addBootstrap(callable $callback): void
    {
        $this->bootstrapCallbacks[] = $callback;
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function addContainer(callable $callback): void
    {
        $this->containerCallbacks[] = $callback;
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function addApp(callable $callback): void
    {
        $this->appCallbacks[] = $callback;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
