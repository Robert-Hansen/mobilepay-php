<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Refund\Factories;

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Contracts\FactoryContract;
use RobertHansen\MobilePay\Refund\DataObjects\Refund;

class RefundFactory implements FactoryContract
{
    public static function make(array $attributes): Refund
    {
        return new Refund(
            refundId: strval(data_get($attributes, 'refundId')),
            paymentId: strval(data_get($attributes, 'paymentId')),
            amount: intval(data_get($attributes, 'amount')),
            createdOn: CarbonImmutable::parse(time: strval(data_get($attributes, 'createdOn'))),
            reference: strval(data_get($attributes, 'reference')),
            description: strval(data_get($attributes, 'description')),
        );
    }
}
