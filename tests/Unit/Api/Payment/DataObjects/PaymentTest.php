<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Api\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Api\Payment\Enums\State;
use RobertHansen\MobilePay\Support\Enums\Money\Currency;

it('can build payment data object', function () {
    $dataObject = new Payment(
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        paymentPointId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        merchantId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        amount: 1000,
        mobilePayAppRedirectUri: 'myapp://redirect',
        state: State::INITIATED,
        paymentPointName: 'Test',
        isoCurrencyCode: Currency::DKK,
        initiatedOn: CarbonImmutable::now(),
        lastUpdatedOn: CarbonImmutable::now(),
        reference: 'test',
        description: 'test',
    );

    expect($dataObject)
        ->toBeInstanceOf(class: Payment::class)
        ->toHaveProperties(names: [
            'paymentId',
            'paymentPointId',
            'merchantId',
            'amount',
            'mobilePayAppRedirectUri',
            'state',
            'paymentPointName',
            'isoCurrencyCode',
            'initiatedOn',
            'lastUpdatedOn',
            'reference',
            'description',
        ])
        ->paymentId->toBeString()
        ->paymentPointId->toBeString()
        ->merchantId->toBeString()
        ->amount->toBeInt()
        ->mobilePayAppRedirectUri->toBeString()
        ->state->toBeInstanceOf(State::class)
        ->paymentPointName->toBeString()
        ->isoCurrencyCode->toBeInstanceOf(Currency::class)
        ->initiatedOn->toBeInstanceOf(DateTimeImmutable::class)
        ->lastUpdatedOn->toBeInstanceOf(DateTimeImmutable::class)
        ->reference->toBeString()
        ->description->toBeString();
});

it('can build payment data object convert it to array', function () {
    $dataObject = new Payment(
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        paymentPointId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        merchantId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        amount: 1000,
        mobilePayAppRedirectUri: 'myapp://redirect',
        state: State::INITIATED,
        paymentPointName: 'Test',
        isoCurrencyCode: Currency::DKK,
        initiatedOn: CarbonImmutable::now(),
        lastUpdatedOn: CarbonImmutable::now(),
        reference: 'test',
        description: 'test',
    );

    expect($dataObject->toArray())
        ->toBeArray()
        ->toHaveKeys(keys: [
            'payment_id',
            'payment_point_id',
            'merchant_id',
            'amount',
            'mobilepay_app_redirect_uri',
            'state',
            'payment_point_name',
            'iso_currency_code',
            'initiated_on',
            'last_updated_on',
            'reference',
            'description',
        ]);
});
