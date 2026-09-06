<div class="filament-hidden">

![Laravel Customer.io](https://raw.githubusercontent.com/jeffersongoncalves/laravel-customer-io/main/art/banner.png)

</div>

# Laravel Customer.io

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-customer-io.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-customer-io)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-customer-io/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-customer-io/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-customer-io/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-customer-io/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-customer-io.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-customer-io)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-customer-io.svg?style=flat-square)](LICENSE.md)

A Laravel client for [Customer.io](https://customer.io)'s **Track API** and **App API**. Covers customer profiles, events, campaigns and transactional messaging through a simple, typed API built on Laravel's `Http` client.

## Features

- Customers (Track/App API): `identify`, `get`, `delete`, `trackEvent`
- Campaigns (App API): `list`, `get`, `metrics`, `trigger`
- Transactional messaging (App API): `sendEmail`
- Throws `CustomerIoException` (with the original API error body) on any non-2xx response

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-customer-io
```

Publish the config file:

```bash
php artisan vendor:publish --tag=customer-io-config
```

Set your Customer.io credentials in `.env`:

```env
CUSTOMERIO_SITE_ID=your-site-id
CUSTOMERIO_API_KEY=your-track-api-key
CUSTOMERIO_APP_KEY=your-app-api-key
```

The site ID and Track API key are found under **Settings > Account Settings > API Credentials**. The App API key is created under **Settings > API Credentials > App API Keys**.

## Configuration

```php
// config/customer-io.php
return [
    'site_id' => env('CUSTOMERIO_SITE_ID', ''),
    'api_key' => env('CUSTOMERIO_API_KEY', ''),
    'app_key' => env('CUSTOMERIO_APP_KEY', ''),
    'track_url' => env('CUSTOMERIO_TRACK_URL', 'https://track.customer.io/api/v1'),
    'app_url' => env('CUSTOMERIO_APP_URL', 'https://api.customer.io/v1'),
];
```

## Usage

The package is resolved via the `CustomerIo` facade or by injecting `JeffersonGoncalves\CustomerIo\CustomerIo`. Each resource is exposed as a method returning a dedicated resource class.

### Customers

```php
use JeffersonGoncalves\CustomerIo\Facades\CustomerIo;

// Create or update a customer profile (Track API)
CustomerIo::customers()->identify('123', [
    'email' => 'jane@example.com',
    'first_name' => 'Jane',
    'plan' => 'premium',
]);

// Fetch a customer's attributes (App API)
$customer = CustomerIo::customers()->get('123');

// Delete a customer (Track API)
CustomerIo::customers()->delete('123');

// Track a custom event (Track API)
CustomerIo::customers()->trackEvent('123', 'purchase', ['amount' => 42]);
```

### Campaigns

```php
$campaigns = CustomerIo::campaigns()->list();

$campaign = CustomerIo::campaigns()->get(1);

$metrics = CustomerIo::campaigns()->metrics(1);

CustomerIo::campaigns()->trigger(1, [
    'emails' => ['jane@example.com'],
    'data' => ['coupon' => 'SAVE10'],
]);
```

### Transactional messaging

```php
CustomerIo::transactional()->sendEmail([
    'transactional_message_id' => '5',
    'to' => 'jane@example.com',
    'identifiers' => ['id' => '123'],
    'message_data' => ['name' => 'Jane'],
]);
```

### Error handling

Any non-2xx API response throws `JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException`, which exposes the decoded error body:

```php
use JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException;

try {
    CustomerIo::customers()->identify('123', ['email' => 'not-an-email']);
} catch (CustomerIoException $e) {
    logger()->error($e->getMessage(), $e->errorBody());
}
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

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
