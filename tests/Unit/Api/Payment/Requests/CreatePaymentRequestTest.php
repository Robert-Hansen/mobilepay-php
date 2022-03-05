<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use RobertHansen\MobilePay\Api\Payment\Requests\CreatePaymentRequest;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('can build create payment request body', function () {
    $requestBody = new CreatePaymentRequest(
        amount: 1000,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect',
        reference: 'this is a test',
        description: 'this is a test',
    );

    expect($requestBody)->toBeInstanceOf(CreatePaymentRequest::class);
});

it('can build create payment request body convert toRequest', function () {
    config()->set('mobilepay.payment_point_id', '655ad36f-70b0-4add-a123-b943daca50e8');

    $requestBody = new CreatePaymentRequest(
        amount: 1000,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect',
        reference: 'this is a test',
        description: 'this is a test',
    );

    expect($requestBody->toRequest())
        ->toBeArray()
        ->amount->toEqual(1000)
        ->idempotencyKey->toEqual('186d2b31-ff25-4414-9fd1-bfe9807fa8b7')
        ->paymentPointId->toEqual('655ad36f-70b0-4add-a123-b943daca50e8')
        ->redirectUri->toEqual('myapp://redirect')
        ->reference->toEqual('this is a test')
        ->description->toEqual('this is a test');
});

it('will fail if create amount is less than 1', function () {
    new CreatePaymentRequest(
        amount: 0,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect'
    );
})->throws(exception: ValidationException::class);

it('will fail if create amount is greater than 2147483647', function () {
    new CreatePaymentRequest(
        amount: 2147483648,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect'
    );
})->throws(exception: ValidationException::class);

it('will fail if create redirectUri invalid url', function () {
    new CreatePaymentRequest(
        amount: 1,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp:///invalid-/'
    );
})->throws(exception: ValidationException::class);

it('will fail if create payment idempotencyKey is not a valid uuid', function () {
    new CreatePaymentRequest(
        amount: 1,
        idempotencyKey: 'invalid',
        redirectUri: 'myapp://redirect'
    );
})->throws(exception: ValidationException::class);

it('will fail if create payment reference is longer than 64 characters', function () {
    new CreatePaymentRequest(
        amount: 1,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect',
        reference: Str::random(65)
    );
})->throws(exception: ValidationException::class);

it('will fail if create payment description is longer than 200 characters', function () {
    new CreatePaymentRequest(
        amount: 1,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect',
        description: Str::random(201)
    );
})->throws(exception: ValidationException::class);

it('can build create payment request body where reference and description is optional', function () {
    config()->set('mobilepay.payment_point_id', '655ad36f-70b0-4add-a123-b943daca50e8');

    $requestBody = new CreatePaymentRequest(
        amount: 1000,
        idempotencyKey: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
        redirectUri: 'myapp://redirect',
    );

    expect($requestBody->toRequest())
        ->toBeArray()
        ->reference->toBeEmpty()
        ->description->toBeEmpty();
});
