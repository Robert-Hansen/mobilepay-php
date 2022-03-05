<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Api\Payment\Requests\CapturePaymentRequest;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('can build capture payment request body', function () {
    $requestBody = new CapturePaymentRequest(amount: 1);

    expect($requestBody)->toBeInstanceOf(CapturePaymentRequest::class);
});

it('can build capture payment request body convert toRequest', function () {
    $requestBody = new CapturePaymentRequest(amount: 100);

    expect($requestBody->toRequest())->toBeArray()->amount->toEqual(100);
});

it('will fail if capture amount is less than 1', function () {
    expect(value: fn() => new CapturePaymentRequest(amount: 0))
        ->toThrow(
            exception: ValidationException::class,
            exceptionMessage: 'Value should be greater than or equal to 1'
        );
});

it('will fail if capture amount is greater than 2147483647', function () {
    expect(value: fn() => new CapturePaymentRequest(amount: 2147483648))
        ->toThrow(
            exception: ValidationException::class,
            exceptionMessage: 'Value should be less than or equal to 2147483647'
        );
});
