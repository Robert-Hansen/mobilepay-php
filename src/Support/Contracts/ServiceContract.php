<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Contracts;

use Illuminate\Http\Client\PendingRequest;

interface ServiceContract
{
    public function __construct(
        string $baseUri,
        string $apiKey,
        string $clientId,
        int $timeout = 10,
        null|int $retryTimes = null,
        null|int $retrySleep = null,
    );

    /**
     * Build the Request.
     *
     * @return PendingRequest
     */
    public function makeRequest(): PendingRequest;
}
