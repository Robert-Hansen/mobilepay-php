<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Facades;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Facade;
use RobertHansen\MobilePay\Client\Factory;
use RobertHansen\MobilePay\Payment\Resources\PaymentResource;
use RobertHansen\MobilePay\Webhook\Resources\WebhookResource;

/**
 * @method static PendingRequest makeRequest()
 * @method static PaymentResource payments()
 * @method static WebhookResource webhooks()
 *
 * @see Factory
 */
class MobilePay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'MobilePay';
    }
}
