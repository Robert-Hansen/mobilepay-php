<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Factories;

use RobertHansen\MobilePay\Support\Contracts\FactoryContract;
use RobertHansen\MobilePay\Support\DataObjects\Error;
use RobertHansen\MobilePay\Support\Enums\ErrorCode;

class ErrorFactory implements FactoryContract
{
    public static function make(array $attributes): Error
    {
        return new Error(
            code: ErrorCode::tryFrom(data_get($attributes, 'code')),
            correlationId: strval(data_get($attributes, 'correlationId')),
            message: strval(data_get($attributes, 'message')),
            origin: strval(data_get($attributes, 'origin')),
        );
    }
}
