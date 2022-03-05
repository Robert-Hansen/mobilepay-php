<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Webhook\Factories;

use RobertHansen\MobilePay\Api\Webhook\DataObjects\Webhook;
use RobertHansen\MobilePay\Api\Webhook\Enums\Event;
use RobertHansen\MobilePay\Support\Contracts\FactoryContract;

class WebhookFactory implements FactoryContract
{
    public static function make(array $attributes): Webhook
    {
        return new Webhook(
            webhookId: strval(data_get($attributes, 'webhookId')),
            url: strval(data_get($attributes, 'url')),
            events: collect(data_get($attributes, 'events'))->map(fn (string $event) => Event::from($event)),
            signatureKey: strval(data_get($attributes, 'signatureKey')),
        );
    }
}
