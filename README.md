Charcoal Slim
=============

[![License][badge-license]][charcoal-slim]
[![Latest Stable Version][badge-version]][charcoal-slim]
[![Code Quality][badge-scrutinizer]][dev-scrutinizer]
[![Coverage Status][badge-coveralls]][dev-coveralls]
[![Build Status][badge-travis]][dev-travis]

Charcoal Slim is a PHP framework to create web applications and APIs using Charcoal components.





## Development

To install the development environment:

```shell
$ composer install
```

To run the scripts (phplint, phpcs, and phpunit):

```shell
$ composer test
```


### Development Dependencies

-   [php-coveralls/php-coveralls][phpcov]
-   [phpunit/phpunit][phpunit]
-   [squizlabs/php_codesniffer][phpcs]



### Coding Style

The charcoal-cache module follows the Charcoal coding-style:

-   [_PSR-1_][psr-1]
-   [_PSR-2_][psr-2]
-   [_PSR-4_][psr-4], autoloading is therefore provided by _Composer_.
-   [_phpDocumentor_](http://phpdoc.org/) comments.
-   [phpcs.xml.dist](phpcs.xml.dist) and [.editorconfig](.editorconfig) for coding standards.

> Coding style validation / enforcement can be performed with `composer phpcs`. An auto-fixer is also available with `composer phpcbf`.



## Credits

-   [Mathieu Ducharme](https://github.com/mducharme)
-   [Chauncey McAskill](https://github.com/mcaskill)
-   [Benjamin Roch](https://github.com/beneroch)
-   [Locomotive](https://locomotive.ca/)



## License

Charcoal is licensed under the MIT license. See [LICENSE](LICENSE) for details.



[charcoal-admin]:        https://packagist.org/packages/locomotivemtl/charcoal-admin
[charcoal-app]:          https://packagist.org/packages/locomotivemtl/charcoal-app
[charcoal-cache]:        https://packagist.org/packages/locomotivemtl/charcoal-cache
[charcoal-cms]:          https://packagist.org/packages/locomotivemtl/charcoal-cms
[charcoal-config]:       https://packagist.org/packages/locomotivemtl/charcoal-config
[charcoal-email]:        https://packagist.org/packages/locomotivemtl/charcoal-email
[charcoal-factory]:      https://packagist.org/packages/locomotivemtl/charcoal-factory
[charcoal-translator]:   https://packagist.org/packages/locomotivemtl/charcoal-translator
[charcoal-view]:         https://packagist.org/packages/locomotivemtl/charcoal-view

[gh-slim]:                  https://github.com/slimphp/Slim/tree/3.x
[gh-pimple]:                https://github.com/silexphp/Pimple
[gh-charcoal-boilerplate]:  https://github.com/locomotivemtl/charcoal-project-boilerplate

[dev-scrutinizer]:    https://scrutinizer-ci.com/g/locomotivemtl/charcoal-app/
[dev-coveralls]:      https://coveralls.io/r/locomotivemtl/charcoal-app
[dev-sensiolabs]:     https://insight.sensiolabs.com/projects/533b5796-7e69-42a7-a046-71342146308a
[dev-travis]:         https://travis-ci.org/locomotivemtl/charcoal-app

[badge-license]:      https://img.shields.io/packagist/l/locomotivemtl/charcoal-app.svg?style=flat-square
[badge-version]:      https://img.shields.io/packagist/v/locomotivemtl/charcoal-app.svg?style=flat-square
[badge-scrutinizer]:  https://img.shields.io/scrutinizer/g/locomotivemtl/charcoal-app.svg?style=flat-square
[badge-coveralls]:    https://img.shields.io/coveralls/locomotivemtl/charcoal-app.svg?style=flat-square
[badge-sensiolabs]:   https://img.shields.io/sensiolabs/i/533b5796-7e69-42a7-a046-71342146308a.svg?style=flat-square
[badge-travis]:       https://img.shields.io/travis/locomotivemtl/charcoal-app.svg?style=flat-square

[climate]:               https://packagist.org/packages/league/climate
[fastroute]:             https://packagist.org/packages/nikic/fast-route
[flysystem]:             https://packagist.org/packages/league/flysystem
[monolog]:               https://packagist.org/packages/monolog/monolog
[mustache]:              https://packagist.org/packages/mustache/mustache
[phpmailer]:             https://packagist.org/packages/phpmailer/phpmailer
[phpunit]:               https://packagist.org/packages/phpunit/phpunit
[phpcs]:                 https://packagist.org/packages/squizlabs/php_codesniffer
[phpcov]:                https://packagist.org/packages/php-coveralls/php-coveralls
[pimple]:                https://packagist.org/packages/pimple/pimple
[slim]:                  https://packagist.org/packages/slim/slim
[stash]:                 https://packagist.org/packages/tedivm/stash
[symfony/translation]:   https://packagist.org/packages/symfony/translation
[twig]:                  https://packagist.org/packages/twig/twig

[psr-1]:  https://www.php-fig.org/psr/psr-1/
[psr-2]:  https://www.php-fig.org/psr/psr-2/
[psr-3]:  https://www.php-fig.org/psr/psr-3/
[psr-4]:  https://www.php-fig.org/psr/psr-4/
[psr-6]:  https://www.php-fig.org/psr/psr-6/
[psr-7]:  https://www.php-fig.org/psr/psr-7/
[psr-11]: https://www.php-fig.org/psr/psr-11/
