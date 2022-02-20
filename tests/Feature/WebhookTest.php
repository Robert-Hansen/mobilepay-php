<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Client\Factory;
use RobertHansen\MobilePay\Facades\MobilePay;
use RobertHansen\MobilePay\Webhook\DataObjects\Webhook;
use RobertHansen\MobilePay\Webhook\Enums\Event;
use RobertHansen\MobilePay\Webhook\Requests\CreateWebhookRequest;
use RobertHansen\MobilePay\Webhook\Requests\UpdateWebhookRequest;
use RobertHansen\MobilePay\Webhook\Resources\WebhookResource;
use Symfony\Component\HttpFoundation\Response;

it('can get a webhook resource', function () {
    expect(value: MobilePay::webhooks())->toBeInstanceOf(class: WebhookResource::class);
});

it('can get webhooks', function () {
    Factory::fake([
        '*/v1/webhooks' => Http::response(
            body:fixture(folder: 'Webhook', name: 'Webhooks'),
            status: Response::HTTP_OK,
        ),
    ]);

    $webhooks = MobilePay::webhooks()->get();

    expect(value: $webhooks)->toBeInstanceOf(class: Collection::class);

    $webhooks->each(function (Webhook $webhook) {
        expect(value: $webhook)->toBeInstanceOf(class: Webhook::class);
    });
});

it('can find a webhook', function () {
    Factory::fake([
        '*/v1/webhooks/e4a2e195-74f6-42e1-a172-83291c9d2a41' => Http::response(
            body: fixture(folder: 'Webhook', name: 'Webhook'),
            status: Response::HTTP_OK,
        ),
    ]);

    $webhook = MobilePay::webhooks()->find(webhookId: 'e4a2e195-74f6-42e1-a172-83291c9d2a41');

    expect(value: $webhook)->toBeInstanceOf(class: Webhook::class)->webhookId->toEqual(expected: 'e4a2e195-74f6-42e1-a172-83291c9d2a41');
});

it('can create a new webhook', function () {
    Factory::fake([
        '/v1/webhooks' => Http::response(
            body: fixture(folder: 'Webhook', name: 'Webhook'),
            status: Response::HTTP_OK,
        ),
    ]);

    $webhook = MobilePay::webhooks()->create(
        requestBody: new CreateWebhookRequest(
            url: 'https://example.org/webhook',
            events: [
                Event::PAYMENT_EXPIRED,
                Event::PAYMENT_RESERVED,
            ],
        ),
    );

    expect(value: $webhook)->toBeInstanceOf(class: Webhook::class)->webhookId->toEqual(expected: 'e4a2e195-74f6-42e1-a172-83291c9d2a41');
});

it('can update a webhook', function () {
    Factory::fake([
        '*/v1/webhooks/e4a2e195-74f6-42e1-a172-83291c9d2a41' => Http::response(
            body: fixture(folder: 'Webhook', name: 'Webhook'),
            status: Response::HTTP_OK,
        ),
    ]);

    $webhook = MobilePay::webhooks()->update(
        webhookId: 'e4a2e195-74f6-42e1-a172-83291c9d2a41',
        requestBody: new UpdateWebhookRequest(
            url: 'https://example.org/webhook',
            events: [
                Event::PAYMENT_EXPIRED,
                Event::PAYMENT_RESERVED,
            ],
        ),
    );

    expect(value: $webhook)->toBeInstanceOf(class: Webhook::class)->url->toEqual(expected: 'https://example.org/webhook');
});

it('can delete a webhook', function () {
    Factory::fake([
        '*/v1/webhooks/e4a2e195-74f6-42e1-a172-83291c9d2a41' => Http::response(status: Response::HTTP_NO_CONTENT),
    ]);

    MobilePay::webhooks()->delete(webhookId: 'e4a2e195-74f6-42e1-a172-83291c9d2a41');

    expect(value: true)->toBeTrue();
});

it('can create a new webhook resource manually', function () {
    expect(value: new WebhookResource(service: resolve('MobilePay')))->toBeInstanceOf(class:  WebhookResource::class);
});
