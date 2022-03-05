<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Api\Payment\DataObjects\CreatePayment;

it('can build create payment data object', function () {
    $dataObject = new CreatePayment(
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        mobilePayAppRedirectUri: 'myapp://redirect',
    );

    expect($dataObject)
        ->toBeInstanceOf(CreatePayment::class)
        ->toHaveProperties(names: [
            'paymentId',
            'mobilePayAppRedirectUri',
        ])
        ->paymentId->toBeString()
        ->mobilePayAppRedirectUri->toBeString();
});

it('can build create payment data object convert it to array', function () {
    $dataObject = new CreatePayment(
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        mobilePayAppRedirectUri: 'myapp://redirect',
    );

    expect($dataObject->toArray())
        ->toBeArray()
        ->toHaveKeys(keys: [
            'payment_id',
            'mobilepay_app_redirect_uri',
        ]);
});
