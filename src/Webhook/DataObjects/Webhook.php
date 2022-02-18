<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Webhook\DataObjects;

use RobertHansen\MobilePay\Contracts\DataObjectContract;

final class Webhook implements DataObjectContract
{
    public function __construct(
        public readonly string $webhookId,
        public readonly string $url,
        public readonly array $events,
        public readonly string $signatureKey,
    ) {}

    public function toArray(): array
    {
        return [
            'webhook_id' => $this->webhookId,
            'url' => $this->url,
            'events' => $this->events,
            'signature_key' => $this->signatureKey,
        ];
    }
}
