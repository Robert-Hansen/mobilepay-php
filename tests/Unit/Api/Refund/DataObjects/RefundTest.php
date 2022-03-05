<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Api\Refund\DataObjects\Refund;
use RobertHansen\MobilePay\Support\Enums\Money\Currency;

it('can build refund data object', function () {
    $dataObject = new Refund(
        refundId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        merchantId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        paymentPointId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        isoCurrencyCode: Currency::DKK,
        amount: 1000,
        createdOn: CarbonImmutable::now(),
        reference: 'test',
        description: 'test',
    );

    expect($dataObject)
        ->toBeInstanceOf(class: Refund::class)
        ->toHaveProperties(names: [
            'refundId',
            'paymentId',
            'merchantId',
            'paymentPointId',
            'isoCurrencyCode',
            'amount',
            'createdOn',
            'reference',
            'description',
        ])
        ->refundId->toBeString()
        ->paymentId->toBeString()
        ->merchantId->toBeString()
        ->paymentPointId->toBeString()
        ->isoCurrencyCode->toBeInstanceOf(Currency::class)
        ->amount->toBeInt()
        ->createdOn->toBeInstanceOf(DateTimeImmutable::class)
        ->reference->toBeString()
        ->description->toBeString();
});

it('can build refund data object convert it to array', function () {
    $dataObject = new Refund(
        refundId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        merchantId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        paymentPointId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        isoCurrencyCode: Currency::DKK,
        amount: 1000,
        createdOn: CarbonImmutable::now(),
        reference: 'test',
        description: 'test',
    );

    expect($dataObject->toArray())
        ->toBeArray()
        ->toHaveKeys(keys: [
            'refund_id',
            'payment_id',
            'merchant_id',
            'payment_point_id',
            'iso_currency_code',
            'amount',
            'created_on',
            'reference',
            'description',
        ]);
});
