<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Payment\Factories;

use RobertHansen\MobilePay\Contracts\FactoryContract;
use RobertHansen\MobilePay\Payment\DataObjects\CreatePayment;

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
