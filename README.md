Charcoal Slim
=============

Charcoal Slim is a PHP framework to create web applications and APIs using Charcoal components.

## Dependencies

- PHP 7.2+
- `slim/slim` and `slim/psr7` For the main PSR-7 App.
- `pimple/pimple` To generate the (PSR-11) DI Container from providers.
- `locomotivemtl/charcoal-config` For the configuration.
- `locomotivemtl/charcoal-view` For templating (mustache, twig) support.
- `guzzlehttp/guzzle` For the HTTP Client (used to proxy requests).


## Development

To install the development environment:

```shell
$ composer install
```

To run the scripts (phplint, phpcs, phpunit and phpstan):

```shell
$ composer test
```


### Development Dependencies

-   [php-coveralls/php-coveralls][phpcov]
-   [phpunit/phpunit][phpunit]
-   [squizlabs/php_codesniffer][phpcs]



### Coding Style

The charcoal-cache module follows the Charcoal coding-style:

-   [_PSR-4_][psr-4], autoloading is therefore provided by _Composer_.
-   [_PSR-12_][psr-12]
-   [_phpDocumentor_](http://phpdoc.org/) comments.
-   [phpcs.xml.dist](phpcs.xml.dist) and [.editorconfig](.editorconfig) for coding standards.

> Coding style validation / enforcement can be performed with `composer phpcs`. An auto-fixer is also available with `composer phpcbf`.



## Credits

-   [Locomotive](https://locomotive.ca/)

## License

Charcoal is licensed under the MIT license. See [LICENSE](LICENSE) for details.
