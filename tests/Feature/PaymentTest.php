<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Api\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Api\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Api\Payment\Requests\CapturePaymentRequest;
use RobertHansen\MobilePay\Api\Payment\Requests\CreatePaymentRequest;
use RobertHansen\MobilePay\Api\Payment\Resources\PaymentResource;
use RobertHansen\MobilePay\Support\Enums\Http\StatusCode;
use RobertHansen\MobilePay\Support\Exceptions\BadRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ConflictRequestException;
use RobertHansen\MobilePay\Support\Exceptions\MobilePayRequestException;
use RobertHansen\MobilePay\Support\Exceptions\ServerInternalErrorException;
use RobertHansen\MobilePay\Support\Exceptions\UnauthorizedException;
use RobertHansen\MobilePay\Support\Facades\MobilePay;

it('can get a payment resource', function () {
    expect(value: MobilePay::payments())
        ->toBeInstanceOf(class: PaymentResource::class);
});

it('can get payments', function () {
    MobilePay::fake([
        '*/v1/payments' => Http::response(
            body:fixture(folder: 'Payment', name: 'Payments'),
            status: StatusCode::HTTP_OK->value,
        ),
    ]);

    $payments = MobilePay::payments()->get();

    expect(value: $payments)
        ->toBeInstanceOf(class: Collection::class)
        ->each->toBeInstanceOf(class: Payment::class);
});

it('can find a payment', function () {
    MobilePay::fake([
        '*/v1/payments/186d2b31-ff25-4414-9fd1-bfe9807fa8b7' => Http::response(
            body: fixture(folder: 'Payment', name: 'Payment'),
            status: StatusCode::HTTP_OK->value,
        ),
    ]);

    $payment = MobilePay::payments()->find(paymentId: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');

    expect(value: $payment)
        ->toBeInstanceOf(class: Payment::class)
        ->paymentId->toEqual(expected: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('can create a new payment', function () {
    MobilePay::fake([
        '/v1/payments' => Http::response(
            body: fixture(folder: 'Payment', name: 'CreatePayment'),
            status: StatusCode::HTTP_OK->value,
        ),
    ]);

    $createPayment = MobilePay::payments()->create(
        requestBody: new CreatePaymentRequest(
            amount: 1050,
            idempotencyKey: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
            redirectUri: 'myapp://redirect',
            reference: 'order-1',
            description: 'this is a test description',
        ),
    );

    expect(value: $createPayment)
        ->toBeInstanceOf(class: CreatePayment::class)
        ->paymentId->toEqual(expected: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('cannot cancel a payment that is already captured', function () {
    MobilePay::fake([
        '/v1/payments/7347ba06-95c5-4181-82e5-7c7a23609a0e/cancel' => Http::response(
            body: [
                'code' => 'invalid_payment_state',
                'correlationId' => '8d4243bc-aa83-43c3-a55d-5da221facd9b',
                'message' => 'Cannot cancel payment that is already captured.',
                'origin' => 'MPY',
            ],
            status: StatusCode::HTTP_CONFLICT->value,
        ),
    ]);

    MobilePay::payments()->cancel(paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e');
})->throws(ConflictRequestException::class);

it('cannot capture payment amount that is larger than is reserved', function () {
    MobilePay::fake([
        '/v1/payments/7347ba06-95c5-4181-82e5-7c7a23609a0e/capture' => Http::response(
            body: [
                'code' => 'amount_too_large',
                'correlationId' => '8d4243bc-aa83-43c3-a55d-5da221facd9b',
                'message' => 'Cannot capture a larger amount than is reserved.',
                'origin' => 'MPY',
            ],
            status: StatusCode::HTTP_CONFLICT->value,
        ),
    ]);

    MobilePay::payments()->capture(
        paymentId: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
        requestBody: new CapturePaymentRequest(amount: 999999)
    );
})->throws(ConflictRequestException::class);

it('test access to api unauthorized access', function () {
    MobilePay::fake([
        '/v1/payments' => Http::response(
            body: [
                'code' => '',
                'correlationId' => '8d4243bc-aa83-43c3-a55d-5da221facd9b',
                'message' => 'unauthorized access',
                'origin' => 'MPY',
            ],
            status: StatusCode::HTTP_UNAUTHORIZED->value,
        ),
    ]);

    MobilePay::payments()->get();
})->throws(UnauthorizedException::class);

it('test a bad request', function () {
    MobilePay::fake([
        '/v1/payments' => Http::response(
            body: [
                'code' => '',
                'correlationId' => '8d4243bc-aa83-43c3-a55d-5da221facd9b',
                'message' => 'something went wrong',
                'origin' => 'MPY',
            ],
            status: StatusCode::HTTP_BAD_REQUEST->value,
        ),
    ]);

    MobilePay::payments()->get();
})->throws(BadRequestException::class);

it('test a internal server error', function () {
    MobilePay::fake([
        '/v1/payments' => Http::response(
            body: [
                'code' => '',
                'correlationId' => '8d4243bc-aa83-43c3-a55d-5da221facd9b',
                'message' => 'something went wrong',
                'origin' => 'MPY',
            ],
            status: StatusCode::HTTP_INTERNAL_SERVER_ERROR->value,
        ),
    ]);

    MobilePay::payments()->get();
})->throws(ServerInternalErrorException::class);

it('throws MobilePayRequestException if there is no match', function () {
    MobilePay::fake([
        '/v1/payments' => Http::response(
            body: [
                'code' => '',
                'correlationId' => '8d4243bc-aa83-43c3-a55d-5da221facd9b',
                'message' => 'something went wrong',
                'origin' => 'MPY',
            ],
            status: 599,
        ),
    ]);

    MobilePay::payments()->get();
})->throws(MobilePayRequestException::class);

it('can create a new payment resource manually', function () {
    expect(value: new PaymentResource(service: resolve('MobilePay')))
        ->toBeInstanceOf(class: PaymentResource::class);
});
