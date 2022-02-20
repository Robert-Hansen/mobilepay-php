<?php

namespace RobertHansen\MobilePay\Webhook\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Contracts\ResourceContract;
use RobertHansen\MobilePay\Contracts\ServiceContract;
use RobertHansen\MobilePay\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Payment\Factories\CreatePaymentFactory;
use RobertHansen\MobilePay\Payment\Requests\CreatePaymentRequest;
use RobertHansen\MobilePay\Webhook\DataObjects\Webhook;
use RobertHansen\MobilePay\Webhook\Factories\WebhookFactory;
use RobertHansen\MobilePay\Webhook\Requests\CreateWebhookRequest;
use RobertHansen\MobilePay\Webhook\Requests\UpdateWebhookRequest;

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

    /**
     * @throws MobilePayRequestException
     */
    public function create(CreateWebhookRequest $requestBody): Webhook
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: "v1/webhooks", data: $requestBody->toRequest());

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return WebhookFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * @throws MobilePayRequestException
     */
    public function update(string $webhookId, UpdateWebhookRequest $requestBody): Webhook
    {
        $request = $this->service()->makeRequest();
        $response = $request->put(url: "v1/webhooks/$webhookId", data: $requestBody->toRequest());

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }

        return WebhookFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * @throws MobilePayRequestException
     */
    public function delete(string $webhookId): void
    {
        $request = $this->service()->makeRequest();
        $response = $request->delete(url: "v1/webhooks/$webhookId");

        if ($response->failed()) {
            throw new MobilePayRequestException(response: $response);
        }
    }
}
