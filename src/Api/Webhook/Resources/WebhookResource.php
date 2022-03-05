<?php

namespace RobertHansen\MobilePay\Api\Webhook\Resources;

use Illuminate\Support\Collection;
use RobertHansen\MobilePay\Api\Webhook\DataObjects\Webhook;
use RobertHansen\MobilePay\Api\Webhook\Factories\WebhookFactory;
use RobertHansen\MobilePay\Api\Webhook\Requests\CreateWebhookRequest;
use RobertHansen\MobilePay\Api\Webhook\Requests\UpdateWebhookRequest;
use RobertHansen\MobilePay\Support\Contracts\ResourceContract;
use RobertHansen\MobilePay\Support\Contracts\ServiceContract;
use RobertHansen\MobilePay\Support\Exceptions\BadRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ConflictRequestException;
use RobertHansen\MobilePay\Support\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ServerInternalErrorException;
use RobertHansen\MobilePay\Support\Exceptions\UnauthorizedException;
use RobertHansen\MobilePay\Support\Resources\AbstractResource;

class WebhookResource extends AbstractResource implements ResourceContract
{
    private string $resource = 'v1/webhooks';

    public function __construct(
        private readonly ServiceContract $service,
    ) {
    }

    public function service(): ServiceContract
    {
        return $this->service;
    }

    /**
     * Gets a list of all webhooks.
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function get(): Collection
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: $this->resource);

        $this->handleFailed($response);

        return collect($response->json('webhooks'))->map(fn (array $webhook) => WebhookFactory::make(
            attributes: $webhook,
        ));
    }

    /**
     * Find a single webhook by its ID.
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function find(string $webhookId): Webhook
    {
        $request = $this->service()->makeRequest();
        $response = $request->get(url: "$this->resource/$webhookId");

        $this->handleFailed($response);

        return WebhookFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * Create a new webhook.
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function create(CreateWebhookRequest $requestBody): Webhook
    {
        $request = $this->service()->makeRequest();
        $response = $request->post(url: $this->resource, data: $requestBody->toRequest());

        $this->handleFailed($response);

        return WebhookFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * Update a webhook by its ID.
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function update(string $webhookId, UpdateWebhookRequest $requestBody): Webhook
    {
        $request = $this->service()->makeRequest();
        $response = $request->put(url: "$this->resource/$webhookId", data: $requestBody->toRequest());

        $this->handleFailed($response);

        return WebhookFactory::make(
            attributes: (array) $response->json(),
        );
    }

    /**
     * Delete a webhook by its ID.
     *
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws MobilePayRequestException
     * @throws ServerInternalErrorException
     * @throws UnauthorizedException
     */
    public function delete(string $webhookId): void
    {
        $request = $this->service()->makeRequest();
        $response = $request->delete(url: "$this->resource/$webhookId");

        $this->handleFailed($response);
    }
}
