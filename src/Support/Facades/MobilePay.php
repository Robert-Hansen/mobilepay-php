<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Facades;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Facade;
use RobertHansen\MobilePay\Api\Payment\Resources\PaymentResource;
use RobertHansen\MobilePay\Api\Refund\Resources\RefundResource;
use RobertHansen\MobilePay\Api\Webhook\Resources\WebhookResource;

/**
 * @method static PendingRequest makeRequest()
 * @method static PaymentResource payments()
 * @method static RefundResource refunds()
 * @method static WebhookResource webhooks()
 * @method static void fake(null|callable|array $callback = null)
 *
 * @see \RobertHansen\MobilePay\MobilePay
 */
class MobilePay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'MobilePay';
    }
}
