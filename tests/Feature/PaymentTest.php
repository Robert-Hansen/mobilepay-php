<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Client\Factory;
use RobertHansen\MobilePay\Facades\MobilePay;
use RobertHansen\MobilePay\Payment\DataObjects\CreatePayment;
use RobertHansen\MobilePay\Payment\DataObjects\Payment;
use RobertHansen\MobilePay\Payment\Requests\CreatePaymentRequest;
use RobertHansen\MobilePay\Payment\Resources\PaymentResource;
use Symfony\Component\HttpFoundation\Response;

it('can get a payment resource', function () {
    expect(MobilePay::payments(), )->toBeInstanceOf(PaymentResource::class);
});

it('can get a single payment', function () {
    Factory::fake([
        '*/v1/payments/*' => Http::response(
            body: fixture('Payment/Payment'),
            status: Response::HTTP_OK,
        ),
    ]);

    $payment = MobilePay::payments()->get(paymentId: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');

    expect($payment)->toBeInstanceOf(Payment::class)->paymentId->toEqual('186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('can fetch payments', function () {
    Factory::fake([
        '*/v1/payments' => Http::response(
            body: fixture('Payment\Payments'),
            status: Response::HTTP_OK,
        ),
    ]);

    $payments = MobilePay::payments()->list();

    expect($payments)->toBeInstanceOf(Collection::class);

    $payments->each(function (Payment $payment) {
        expect($payment)->toBeInstanceOf(Payment::class);
    });
});

it('can create a new payment', function () {
    Factory::fake([
        '/v1/payments' => Http::response(
            body: fixture('Payment/CreatePayment'),
            status: Response::HTTP_OK,
        ),
    ]);

    $createPayment = MobilePay::payments()->create(
        requestBody: new CreatePaymentRequest(
            amount: 1050,
            idempotencyKey: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
            paymentPointId: '655ad36f-70b0-4add-a123-b943daca50e8',
            redirectUri: 'myapp://redirect',
            reference: 'order-1',
            description: 'this is a test description',
        ),
    );

    expect($createPayment)->toBeInstanceOf(CreatePayment::class)->paymentId->toEqual('186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('can create a new payment resource manually', function () {
    expect(new PaymentResource(service: resolve('MobilePay')))->toBeInstanceOf(PaymentResource::class);
});
