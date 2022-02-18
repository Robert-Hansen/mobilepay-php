<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Client;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Concerns\CanBeFaked;
use RobertHansen\MobilePay\Contracts\ServiceContract;
use RobertHansen\MobilePay\Payment\Resources\PaymentResource;
use RobertHansen\MobilePay\Webhook\Resources\WebhookResource;

class Factory implements ServiceContract
{
    use CanBeFaked;

    public function __construct(
        public readonly string $baseUri,
        public readonly string $apiKey,
        public readonly string $clientId,
        public readonly int $timeout = 10,
        public readonly null|int $retryTimes = null,
        public readonly null|int $retrySleep = null,
    ) {}

    public function makeRequest(): PendingRequest
    {
        $request = Http::baseUrl(url: $this->baseUri)
                       ->timeout(seconds: $this->timeout)
                       ->acceptJson()
                       ->withToken(token: $this->apiKey)
                       ->withUserAgent(userAgent: 'MobilePay Client')
                       ->withHeaders(['x-ibm-client-id' => $this->clientId]);

        if (! is_null($this->retryTimes) && ! is_null($this->retrySleep)) {
            $request->retry(times: $this->retryTimes, sleep: $this->retrySleep);
        }

        return $request;
    }

    public function payments(): PaymentResource
    {
        return new PaymentResource(service: $this);
    }

    public function webhooks(): WebhookResource
    {
        return new WebhookResource(service: $this);
    }
}
