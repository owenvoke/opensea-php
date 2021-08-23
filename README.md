# OpenSea PHP

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-github-actions]][link-github-actions]
[![Style CI][ico-styleci]][link-styleci]
[![Total Downloads][ico-downloads]][link-downloads]
[![Buy us a tree][ico-treeware-gifting]][link-treeware-gifting]

An object oriented PHP wrapper for the OpenSea API

## Requirements

- PHP >= 7.4
- A [PSR-17 implementation](https://packagist.org/providers/psr/http-factory-implementation)
- A [PSR-18 implementation](https://packagist.org/providers/psr/http-client-implementation)

## Install

Via Composer

```shell
$ composer require owenvoke/opensea guzzlehttp/guzzle:^7.0.1 http-interop/http-factory-guzzle:^1.0
```

We are decoupled from any HTTP messaging client with help by [HTTPlug](https://httplug.io).

## Usage

**Basic usage**

```php
// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

$client = new \OwenVoke\OpenSea\Client();
$repositories = $client->assets()->all();
```

**Authentication**

> Note: OpenSea only supports authentication via an API token.

```php
use OwenVoke\OpenSea\Client;
$client = new Client();
$client->authenticate($apiToken, null, Client::AUTH_ACCESS_TOKEN);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```shell
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@voke.dev instead of using the issue tracker.

## Credits

- [Owen Voke][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees [here][link-treeware-gifting].

Read more about Treeware at [treeware.earth][link-treeware].

[ico-version]: https://img.shields.io/packagist/v/owenvoke/opensea.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-github-actions]: https://img.shields.io/github/workflow/status/owenvoke/opensea-php/Tests.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/000000/shield
[ico-downloads]: https://img.shields.io/packagist/dt/owenvoke/opensea.svg?style=flat-square
[ico-treeware-gifting]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen?style=flat-square

[link-packagist]: https://packagist.org/packages/owenvoke/opensea
[link-github-actions]: https://github.com/owenvoke/opensea-php/actions
[link-styleci]: https://styleci.io/repos/000000
[link-downloads]: https://packagist.org/packages/owenvoke/opensea
[link-treeware]: https://treeware.earth
[link-treeware-gifting]: https://ecologi.com/owenvoke?gift-trees
[link-author]: https://github.com/owenvoke
[link-contributors]: ../../contributors
