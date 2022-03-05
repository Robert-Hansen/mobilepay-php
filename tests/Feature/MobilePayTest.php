<?php

declare(strict_types=1);

use Illuminate\Http\Client\PendingRequest;
use RobertHansen\MobilePay\MobilePay as MobilePayClient;
use RobertHansen\MobilePay\Support\Facades\MobilePay;

it('can build a mobilepay client', function () {
    expect(MobilePay::getFacadeRoot())->toBeInstanceOf(MobilePayClient::class);
});

it('can create a Pending Request', function () {
    expect(MobilePay::makeRequest())->toBeInstanceOf(PendingRequest::class);
});

it('can resolve a MobilePay from the container', function () {
    expect(resolve(MobilePay::class))->toBeInstanceOf(MobilePay::class);
});
