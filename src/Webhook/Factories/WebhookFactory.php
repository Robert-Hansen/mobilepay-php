<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Webhook\Factories;

use RobertHansen\MobilePay\Contracts\FactoryContract;
use RobertHansen\MobilePay\Webhook\DataObjects\Webhook;

class WebhookFactory implements FactoryContract
{
    public static function make(array $attributes): Webhook
    {
        return new Webhook(
            webhookId: strval(data_get($attributes, 'webhookId')),
            url: strval(data_get($attributes, 'url')),
            events: (array) (data_get($attributes, 'events')),
            signatureKey: strval(data_get($attributes, 'signatureKey')),
        );
    }
}
