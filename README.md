# SMS component

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lbhurtado/sms.svg?style=flat-square)](https://packagist.org/packages/lbhurtado/sms)
[![Build Status](https://img.shields.io/travis/lbhurtado/sms/master.svg?style=flat-square)](https://travis-ci.org/lbhurtado/sms)
[![Quality Score](https://img.shields.io/scrutinizer/g/lbhurtado/sms.svg?style=flat-square)](https://scrutinizer-ci.com/g/lbhurtado/sms)
[![Total Downloads](https://img.shields.io/packagist/dt/lbhurtado/sms.svg?style=flat-square)](https://packagist.org/packages/lbhurtado/sms)

Driver-based SMS component in Laravel inspired by the tutorial of Orobo Lucky.

## Installation

You can install the package via composer:

```bash
composer require lbhurtado/sms
```

## Usage

``` php
use LBHurtado\SMS\Facades\SMS;

$mobile = '+639171234567';
$message = 'The quick brown fox...';
$amount = 25;

SMS::channel('engagespark')
    ->to($mobile)
    ->content($message)
    ->send()
    ;
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email lester@hurtado.ph instead of using the issue tracker.

## Credits

- [Lester Hurtado](https://github.com/lbhurtado)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
