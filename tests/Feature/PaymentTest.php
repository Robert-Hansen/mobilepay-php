<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Client\Factory;
use RobertHansen\MobilePay\Enums\Http\StatusCode;
use RobertHansen\MobilePay\Facades\MobilePay;
use RobertHansen\MobilePay\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Payment\Requests\CreatePaymentRequest;
use RobertHansen\MobilePay\Payment\Resources\PaymentResource;

it('can get a payment resource', function () {
    expect(value: MobilePay::payments())->toBeInstanceOf(class: PaymentResource::class);
});

it('can get payments', function () {
    Factory::fake([
        '*/v1/payments' => Http::response(
            body:fixture(folder: 'Payment', name: 'Payments'),
            status: StatusCode::HTTP_OK->value,
        ),
    ]);

    $payments = MobilePay::payments()->get();

    expect(value: $payments)->toBeInstanceOf(class: Collection::class);

    $payments->each(function (Payment $payment) {
        expect(value: $payment)->toBeInstanceOf(class: Payment::class);
    });
});

it('can find a payment', function () {
    Factory::fake([
        '*/v1/payments/186d2b31-ff25-4414-9fd1-bfe9807fa8b7' => Http::response(
            body: fixture(folder: 'Payment', name: 'Payment'),
            status: StatusCode::HTTP_OK->value,
        ),
    ]);

    $payment = MobilePay::payments()->find(paymentId: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');

    expect(value: $payment)->toBeInstanceOf(class: Payment::class)->paymentId->toEqual(expected: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('can create a new payment', function () {
    Factory::fake([
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

    expect(value: $createPayment)->toBeInstanceOf(class: CreatePayment::class)->paymentId->toEqual(expected: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('can create a new payment resource manually', function () {
    expect(value: new PaymentResource(service: resolve('MobilePay')))->toBeInstanceOf(class: PaymentResource::class);
});
