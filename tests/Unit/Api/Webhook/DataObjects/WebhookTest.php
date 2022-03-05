<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Api\Webhook\DataObjects\Webhook;
use RobertHansen\MobilePay\Api\Webhook\Enums\Event;

it('can build webhook data object', function () {
    $dataObject = new Webhook(
        webhookId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        url: 'https://example.org',
        events: collect([
            Event::PAYMENT_RESERVED,
            Event::PAYMENT_EXPIRED,
            Event::PAYMENT_CANCELLED_BY_USER,
        ]),
        signatureKey: '7347ba0695c5418182e57c7a23609a0e',
    );

    expect($dataObject)
        ->toBeInstanceOf(class: Webhook::class)
        ->toHaveProperties(names: [
            'webhookId',
            'url',
            'events',
            'signatureKey',
        ])
        ->webhookId->toBeString()
        ->url->toBeString()
        ->events->toBeInstanceOf(Collection::class)->each->toBeInstanceOf(Event::class)
        ->signatureKey->toBeString();
});

it('can build webhook data object convert it to array', function () {
    $dataObject = new Webhook(
        webhookId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        url: 'https://example.org',
        events: collect([
            Event::PAYMENT_RESERVED,
            Event::PAYMENT_EXPIRED,
            Event::PAYMENT_CANCELLED_BY_USER,
        ]),
        signatureKey: '7347ba0695c5418182e57c7a23609a0e',
    );

    expect($dataObject->toArray())
        ->toBeArray()
        ->toHaveKeys(keys: [
            'webhook_id',
            'url',
            'events',
            'signature_key',
        ]);
});
