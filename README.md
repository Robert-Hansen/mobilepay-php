# mobilepay-php

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robert-hansen/mobilepay-php.svg?style=flat-square)](https://packagist.org/packages/robert-hansen/mobilepay-php)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/robert-hansen/mobilepay-php/run-tests?label=tests)](https://github.com/robert-hansen/mobilepay-php/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/robert-hansen/mobilepay-php/Check%20&%20fix%20styling?label=code%20style)](https://github.com/robert-hansen/mobilepay-php/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/robert-hansen/mobilepay-php.svg?style=flat-square)](https://packagist.org/packages/robert-hansen/mobilepay-php)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require robert-hansen/mobilepay-php
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mobilepay-php-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$mobilePay = app(MobilePay::class);

$payments = $mobilePay->payments()->list();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Robert](https://github.com/robert-hansen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
