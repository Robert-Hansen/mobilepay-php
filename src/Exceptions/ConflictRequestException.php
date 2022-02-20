<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Exceptions;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\Response;
use RobertHansen\MobilePay\Factories\ErrorFactory;

class ConflictRequestException extends HttpClientException
{
    public function __construct(public readonly Response $response)
    {
        parent::__construct($this->prepareMessage($response), $response->status());
    }

    protected function prepareMessage(Response $response): string
    {
        $error = ErrorFactory::make($response->json());

        return sprintf('[%s] %s correlationId: %s', $error->code->value, $error->message, $error->correlationId);
    }
}
