<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Exceptions;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\Response;
use RobertHansen\MobilePay\Support\Factories\ErrorFactory;

class BadRequestException extends HttpClientException
{
    public function __construct(public readonly Response $response)
    {
        parent::__construct($this->prepareMessage($response), $response->status());
    }

    protected function prepareMessage(Response $response): string
    {
        $error = ErrorFactory::make($response->json());

        return sprintf('Message: %s correlationId: %s', $error->message, $error->correlationId);
    }
}
