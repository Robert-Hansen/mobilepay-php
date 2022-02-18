<?php

declare(strict_types=1);

use Illuminate\Http\Client\PendingRequest;
use RobertHansen\MobilePay\Client\Factory;
use RobertHansen\MobilePay\Facades\MobilePay;

it('can build a mobilepay client', function () {
    expect(MobilePay::getFacadeRoot())->toBeInstanceOf(Factory::class);
});

it('can create a Pending Request', function () {
    expect(MobilePay::makeRequest())->toBeInstanceOf(PendingRequest::class);
});

it('can resolve a MobilePay from the container', function () {
    expect(resolve(MobilePay::class))->toBeInstanceOf(MobilePay::class);
});
