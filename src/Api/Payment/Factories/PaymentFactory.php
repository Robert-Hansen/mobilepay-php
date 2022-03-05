<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Payment\Factories;

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Api\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Api\Payment\Enums\State;
use RobertHansen\MobilePay\Support\Contracts\FactoryContract;
use RobertHansen\MobilePay\Support\Enums\Money\Currency;

class PaymentFactory implements FactoryContract
{
    public static function make(array $attributes): Payment
    {
        return new Payment(
            paymentId: strval(data_get($attributes, 'paymentId')),
            paymentPointId: strval(data_get($attributes, 'paymentPointId')),
            merchantId: strval(data_get($attributes, 'merchantId')),
            amount: intval(data_get($attributes, 'amount')),
            mobilePayAppRedirectUri: strval(data_get($attributes, 'mobilePayAppRedirectUri')),
            state: State::from(data_get($attributes, 'state')),
            paymentPointName: strval(data_get($attributes, 'paymentPointName')),
            isoCurrencyCode: Currency::from(data_get($attributes, 'isoCurrencyCode')),
            initiatedOn: CarbonImmutable::parse(time: strval(data_get($attributes, 'initiatedOn'))),
            lastUpdatedOn: CarbonImmutable::parse(time: strval(data_get($attributes, 'lastUpdatedOn'))),
            reference: strval(data_get($attributes, 'reference')),
            description: strval(data_get($attributes, 'description')),
        );
    }
}
