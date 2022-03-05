<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Refund\Factories;

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Api\Refund\DataObjects\Refund;
use RobertHansen\MobilePay\Support\Contracts\FactoryContract;
use RobertHansen\MobilePay\Support\Enums\Money\Currency;

class RefundFactory implements FactoryContract
{
    public static function make(array $attributes): Refund
    {
        return new Refund(
            refundId: strval(data_get($attributes, 'refundId')),
            paymentId: strval(data_get($attributes, 'paymentId')),
            merchantId: strval(data_get($attributes, 'merchantId')),
            paymentPointId: strval(data_get($attributes, 'paymentPointId')),
            isoCurrencyCode: Currency::from(data_get($attributes, 'isoCurrencyCode')),
            amount: intval(data_get($attributes, 'amount')),
            createdOn: CarbonImmutable::parse(time: strval(data_get($attributes, 'createdOn'))),
            reference: strval(data_get($attributes, 'reference')),
            description: strval(data_get($attributes, 'description')),
        );
    }
}
