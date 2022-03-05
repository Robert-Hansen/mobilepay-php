<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Payment\Factories;

use RobertHansen\MobilePay\Api\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Support\Contracts\FactoryContract;

class CreatePaymentFactory implements FactoryContract
{
    public static function make(array $attributes): CreatePayment
    {
        return new CreatePayment(
            paymentId: strval(data_get($attributes, 'paymentId')),
            mobilePayAppRedirectUri: strval(data_get($attributes, 'mobilePayAppRedirectUri')),
        );
    }
}
