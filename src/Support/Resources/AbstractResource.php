<?php

namespace RobertHansen\MobilePay\Support\Resources;

use Illuminate\Http\Client\Response;
use RobertHansen\MobilePay\Support\Enums\Http\StatusCode;
use RobertHansen\MobilePay\Support\Exceptions\BadRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ConflictRequestException;
use RobertHansen\MobilePay\Support\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ServerInternalErrorException;
use RobertHansen\MobilePay\Support\Exceptions\UnauthorizedException;

abstract class AbstractResource
{
    /**
     * @throws UnauthorizedException
     * @throws BadRequestException
     * @throws ConflictRequestException
     * @throws ServerInternalErrorException
     * @throws MobilePayRequestException
     */
    protected function handleFailed(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        match (StatusCode::tryFrom(value: $response->status())) {
            StatusCode::HTTP_UNAUTHORIZED => throw new UnauthorizedException(response: $response),
            StatusCode::HTTP_BAD_REQUEST => throw new BadRequestException(response: $response),
            StatusCode::HTTP_CONFLICT => throw new ConflictRequestException(response: $response),
            StatusCode::HTTP_INTERNAL_SERVER_ERROR => throw new ServerInternalErrorException(response: $response),
            default => throw new MobilePayRequestException(response: $response),
        };
    }
}
