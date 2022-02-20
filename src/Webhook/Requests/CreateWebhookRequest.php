<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Webhook\Requests;

final class CreateWebhookRequest
{
    public function __construct(
        public readonly string $url,
        public readonly array $events,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'url' => $this->url,
            'events' => $this->events,
        ];
    }
}
