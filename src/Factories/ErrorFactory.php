<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Factories;

use RobertHansen\MobilePay\Contracts\FactoryContract;
use RobertHansen\MobilePay\DataObjects\Error;
use RobertHansen\MobilePay\Payment\Enums\ErrorCode;

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
