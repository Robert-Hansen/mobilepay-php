<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Webhook\DataObjects;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use RobertHansen\MobilePay\Support\Contracts\DataObjectContract;

final class Webhook implements DataObjectContract
{
    /**
     * Unique identifier for the webhook.
     * @param string $webhookId
     *
     * The URL of the webhook endpoint.
     * @param string $url
     *
     * List of subscribed events.
     * @param Collection $events
     *
     * The webhook's secret is used to generate webhook signatures.
     * @param string $signatureKey
     */
    public function __construct(
        public readonly string $webhookId,
        public readonly string $url,
        public readonly Collection $events,
        public readonly string $signatureKey,
    ) {
    }

    #[ArrayShape([
        'webhook_id' => "string",
        'url' => "string",
        'events' => "array",
        'signature_key' => "string"
    ])]
    public function toArray(): array
    {
        return [
            'webhook_id' => $this->webhookId,
            'url' => $this->url,
            'events' => $this->events->toArray(),
            'signature_key' => $this->signatureKey,
        ];
    }
}
