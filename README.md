Charcoal Slim
=============

Charcoal Slim is a PHP framework to create web applications and APIs using Charcoal components.

## Dependencies

- PHP 7.4+
- `slim/slim` and `slim/psr7` For the main PSR-7 App.
- `pimple/pimple` To generate the (PSR-11) DI Container from service-providers.
- `charcoal/config` For the configuration format.
- `charcoal/view` For templating (mustache, twig) support.
- `guzzlehttp/guzzle` For the HTTP Client (used to proxy requests).

## How does it work?

> View [mducharme/slim4-boilerplate](https://github.com/mducharme/slim4-boilerplate) for an example implementation.

### The Bootstrap class

The Bootstrap class can be used to set up a slim application, with a charcoal configuration object and a pimple container.
The charcoal configuration object can be set with PHP and JSON. The pimple container is typically used as a dependency 
injection container and is set with service providers.

Typically, the bootstrap will be passed a bunch of callback functions that will be executed when starting the app. 

There are 4 types of callback methods that can be added, depending on which object they need to modify.

- **Config** callbacks can be added with `$bootstrap->addConfig(function (\Charcoal\Config\ConfigInterface $config) : \Charcoal\Config\ConfigInterface { /* */ });`
  - This is how to add custom configuration to an app, and would most likely be used for every project, typically to load the JSON (and php) config files.
- **Container** callbacks can be added with `$bootstrap->addContainer(function (\Pimple\Container $container) : \Pimple\Container { /* */ });`
  - This is how to register custom service providers on the Pimple DI container.
- **Bootstrap** callbacks can be added with `$bootstrap->addBootstrap(function (\Charcoal\Slim\Bootstrap $bootstrap) : \Charcoal\Slim\Bootstrap { /* */ });`
  - This is how to add Charcoal modules or any other system that needs to add more config, container or app callbacks to the process.
- **App** callbacks can be added with `$bootstrap->addApp(function \Slim\App $app): \Slim\App { /* */ });`
  - This is how to add any (psr-15) middlewares or route / route handlers to the Slim app.

Here is how a typical Charcoal project's front controller (`index.php`) may look:

```php
$bootstrap = new \Charcoal\Slim\Bootstrap();
$bootstrap->addConfig((require __DIR__ . '/../app/config.php'));
$bootstrap->addContainer((require __DIR__ . '/../app/services.php'));
$bootstrap->addBootstrap((require __DIR__ . '/../app/modules.php'));
$bootstrap->addApp((require __DIR__ . '/../app/middlewares.php'));
$bootstrap->addApp((require __DIR__ . '/../app/routes.php'));
$app = $bootstrap();
$app->run();
```

(All the `app/*.php` files should return a callback function that matches the appropriate signature.)

### The Route Mapper

The Route Mapper is an essential service provided by this library. 
It will transform a "route definition" array into an actual Slim route for the app.

Here is JSON example of different route definitions.

```json
{
    "routes": {
        "home": {
            "type": "view",
            "view": "contexts/views/home",
            "template": "view/home"
        },
        "redirect-example": {
            "type": "redirect",
            "target" "https://foo.com/"
        },
        "json-api-example": {
            "type": "json",
            "context": "contexts/foobar"
        }
    }
    
}
```

> The `type` is required. It must match a defined route handler. See below for the 5 handlers available by default

To set up those routes on the app:

```php
$routeMapper = new RouteMapper();
$routeMapper($app, $config['routes']);
```

#### Adding a route manually


### The 5 core (default) types of handler

- **Controller** (`\Charcoal\Slim\Handlers\Controller`)
    - Configuration
        - `controller`
- **JSON** (`\Charcoal\Slim\Handlers\Controller`)
    - Configuration
        - `context`
- **Proxy** (`\Charcoal\Slim\Handlers\Controller`)
    - Configuration
        - `url`
        - `requestOptions`
        - `proxyMethod` (Optional, use current request method if unspecified)
- **Redirection** (`\Charcoal\Slim\Handlers\Redirection`)
    - Configuration:
        - `target`
        - `code` (default = 301)
- **View** (`\Charcoal\Slim\Handlers\View`)
    - Configuration
        - `engine` (Optional, use app default if unspecified)
        - `template`
        - `view` (Optional view controller)

### Default service providers

There are 2 available service providers:
- \Charcoal\Slim\Services\ControllersProvider
  - Provide (empty) `app/controllers` and `app/contexts`.
- \Charcoal\Slim\Services\HandlersProvider
  - Provide (empty) `app/handlers`.

 Important: note that those providers must be registered manually to the app container, with
 ```php
$bootstrap->addToContainer(function callback(Container $container) {
    $container->register(new \Charcoal\Slim\Services\HandlersProvider());
    $container->extends(
        'app/handlers', 
        function(array $handlers, Container $container) : array {
           // Add custom route handlers here
           $handlers['custom'] = \App\Handlers\CustomHandler::class;
           return $handlers;
        }
    );
     
    $container->register(new ControllersProvider());
    $container->extend(
        'app/controllers',
        function (array $controllers, Container $container): array {
            // Add custom route controllers here
            $controllers['custom'] = \App\Controllers\Custom::class;
            return $controllers;
        }
    );
    $container->extend(
        'app/contexts',
        function (array $contexts, Container $container): array {
            // Add custom json or view contexts here
            $contexts['custom'] = \App\Contexts\Custom::class;
            $contexts['views/custom'] = \App\Contexts\Views\Custom::class;
            return $contexts;
        }
    );
});


```


## Development

To install the development environment:

```shell
$ composer install
```

To run the scripts (phplint, phpcs, phpunit, phpstan and psalm):

```shell
$ composer test
```


### Development Dependencies

-   [php-coveralls/php-coveralls](phpcov)
-   [phpunit/phpunit](phpunit)
-   [squizlabs/php_codesniffer](phpcs)



### Coding Style

The charcoal-slim module follows the Charcoal coding-style:

-   [_PSR-4_][psr-4], autoloading is therefore provided by _Composer_.
-   [_PSR-12_][psr-12]
-   [_phpDocumentor_](http://phpdoc.org/) comments.
-   [phpcs.xml.dist](phpcs.xml.dist) and [.editorconfig](.editorconfig) for coding standards.

> Coding style validation / enforcement can be performed with `composer phpcs`. An auto-fixer is also available with `composer phpcbf`.



## Credits

-   [Locomotive](https://locomotive.ca/)

## License

Charcoal is licensed under the MIT license. See [LICENSE](LICENSE) for details.
