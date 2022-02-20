# MobilePay for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robert-hansen/mobilepay-php.svg?style=flat-square)](https://packagist.org/packages/robert-hansen/mobilepay-php)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/robert-hansen/mobilepay-php/run-tests?label=tests)](https://github.com/robert-hansen/mobilepay-php/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/robert-hansen/mobilepay-php/Check%20&%20fix%20styling?label=code%20style)](https://github.com/robert-hansen/mobilepay-php/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/robert-hansen/mobilepay-php.svg?style=flat-square)](https://packagist.org/packages/robert-hansen/mobilepay-php)

MobilePay API for Laravel 9.x

## Installation

You can install the package via composer:

```bash
composer require robert-hansen/mobilepay-php
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mobilepay-php-config"
```

Just set the below environment variables in your .env.

```
MOBILEPAY_CLIENT_ID=
MOBILEPAY_API_KEY=
MOBILEPAY_PAYMENT_POINT_ID=
MOBILEPAY_WEBHOOK_SIGNATURE_KEY=
```

## Usage

### Payments
```php
    // list of payments
    $payments = MobilePay::payments()->list();
    
    // get a single payment
    $payment = MobilePay::payments()->get(paymentId: $paymentId);
    
    // create payment
    $requestBody = new CreatePaymentRequest(
        amount: 1050,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect',
        reference: 'order-1',
        description: 'this is a test description',
    );
    
    $payment = MobilePay::payments()->create(requestBody: $requestBody);
    
    //cancel payment
    MobilePay::payments()->cancel(paymentId: '09d6772e-8ac0-4738-9f9c-a2a1891c1a26');
    
    // capture payment
    $requestBody = new CapturePaymentRequest(amount: 1000);
    
    MobilePay::payments()->capture(paymentId: '9a4d52cf-c994-42b6-8995-61e4598514e5', requestBody: $requestBody);
```

### Refunds
```php
    // list refunds
    $listOptions = new ListOptionsFilter(
        pageSize: 10,
        pageNumber: 1,
        paymentId: '223dbe4e-2d3b-4484-b870-6c86cff2c07b',
        paymentPointId: '4741751c-2935-41f1-a743-0b960f668869',
        createdBefore: CarbonImmutable::now(),
        createdAfter: CarbonImmutable::now()->subMonth(),
    );
    
    $refunds = MobilePay::refunds()->list(listOptions: $listOptions);
    
    // get a single refund
    $refund = MobilePay::refunds()->get(refundId: "4741751c-2935-41f1-a743-0b960f668869");
    
    // create a refund
    $requestBody = new CreateRefundRequest(
        paymentId: '223dbe4e-2d3b-4484-b870-6c86cff2c07b',
        amount: 1000,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        reference: 'order-1',
        description: 'refund description'
    );
    
    $refund = MobilePay::refunds()->create(requestBody: $requestBody);
```

### Webhooks
```php
    // list of webhooks
    $webhooks = MobilePay::webhooks()->list();
    
    // get a single webhook
    $webhook = MobilePay::webhooks()->get(webhookId: '76385cef-5f92-ec11-908e-00505686acfb');
    
    // create webhook
    $requestBody = new CreateWebhookRequest(
        url: "https://example.org/webhook",
        events: [
            Event::PAYMENT_RESERVED,
            Event::PAYMENT_EXPIRED,
        ],
    );
    
    $webhook = MobilePay::webhooks()->create(requestBody: $requestBody);
    
    // update a webhook
    $requestBody = new UpdateWebhookRequest(
        url: 'https://example.org/webhook',
        events: [
            Event::PAYMENT_RESERVED,
        ],
    );
    
    $webhook = MobilePay::webhooks()->update(webhookId: '76385cef-5f92-ec11-908e-00505686acfb', requestBody: $requestBody);
    
    // delete a webhook
    MobilePay::webhooks()->delete(webhookId: '76385cef-5f92-ec11-908e-00505686acfb');
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
