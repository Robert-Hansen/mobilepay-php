<?php

namespace RobertHansen\MobilePay\Webhook\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Contracts\ResourceContract;
use RobertHansen\MobilePay\Contracts\ServiceContract;
use RobertHansen\MobilePay\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Webhook\DataObjects\Webhook;
use RobertHansen\MobilePay\Webhook\Factories\WebhookFactory;

class WebhookResource implements ResourceContract
{
    public function __construct(
        private readonly ServiceContract $service,
    ) {
    }

    public function service(): ServiceContract
    {
        return $this->service;
    }

    /**
     * @throws MobilePayRequestException
     */
    public function list(): Collection
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "v1/webhooks");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return collect($response->json('webhooks'))->map(fn (array $webhook) => WebhookFactory::make(
            attributes: $webhook,
        ));
    }

    /**
     * @throws MobilePayRequestException
     */
    public function get(string $webhookId): Webhook
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "v1/webhooks/$webhookId");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return WebhookFactory::make(
            attributes: (array) $response->json(),
        );
    }
}
