<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Api\Payment\Resources\PaymentResource;
use RobertHansen\MobilePay\Api\Refund\Resources\RefundResource;
use RobertHansen\MobilePay\Api\Webhook\Resources\WebhookResource;
use RobertHansen\MobilePay\Support\Concerns\CanBeFaked;
use RobertHansen\MobilePay\Support\Contracts\ServiceContract;

class MobilePay implements ServiceContract
{
    use CanBeFaked;

    public function __construct(
        public readonly string $baseUri,
        public readonly string $apiKey,
        public readonly string $clientId,
        public readonly int $timeout = 10,
        public readonly null|int $retryTimes = null,
        public readonly null|int $retrySleep = null,
    ) {
    }

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

    public function refunds(): RefundResource
    {
        return new RefundResource(service: $this);
    }
}
