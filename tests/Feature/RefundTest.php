<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RobertHansen\MobilePay\Api\Refund\DataObjects\Refund;
use RobertHansen\MobilePay\Api\Refund\Filters\ListOptionsFilter;
use RobertHansen\MobilePay\Api\Refund\Requests\CreateRefundRequest;
use RobertHansen\MobilePay\Api\Refund\Resources\RefundResource;
use RobertHansen\MobilePay\Support\Facades\MobilePay;
use Symfony\Component\HttpFoundation\Response;

it('can get a refund resource', function () {
    expect(value: MobilePay::refunds())->toBeInstanceOf(class: RefundResource::class);
});

it('can get refunds', function () {
    MobilePay::fake([
        '*/v1/refunds?pageSize=10&pageNumber=1' => Http::response(
            body:fixture(folder: 'Refund', name: 'Refunds'),
            status: Response::HTTP_OK,
        ),
    ]);

    $listOptions = new ListOptionsFilter(
        pageSize: 10,
        pageNumber: 1,
    );

    $refunds = MobilePay::refunds()->get($listOptions);

    expect(value: $refunds)->toBeInstanceOf(class: Collection::class);

    $refunds->each(function (Refund $refund) {
        expect(value: $refund)->toBeInstanceOf(class: Refund::class);
    });
});

it('can find a refund', function () {
    MobilePay::fake([
        '*/v1/refunds/7576910d-9789-4fef-a72e-877d89afec94' => Http::response(
            body: fixture(folder: 'Refund', name: 'Refund'),
            status: Response::HTTP_OK,
        ),
    ]);

    $refunds = MobilePay::refunds()->find(refundId: '7576910d-9789-4fef-a72e-877d89afec94');

    expect(value: $refunds)->toBeInstanceOf(class: Refund::class)->refundId->toEqual(expected: '7576910d-9789-4fef-a72e-877d89afec94');
});

it('can create a new refund', function () {
    MobilePay::fake([
        '/v1/refunds' => Http::response(
            body: fixture(folder: 'Refund', name: 'Refund'),
            status: Response::HTTP_OK,
        ),
    ]);

    $refund = MobilePay::refunds()->create(
        requestBody: new CreateRefundRequest(
            paymentId: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7',
            amount: 1050,
            idempotencyKey: '7347ba06-95c5-4181-82e5-7c7a23609a0e',
            reference: 'order-1',
            description: 'this is a test description',
        ),
    );

    expect(value: $refund)->toBeInstanceOf(class: Refund::class)->paymentId->toEqual(expected: '186d2b31-ff25-4414-9fd1-bfe9807fa8b7');
});

it('can create a new refund resource manually', function () {
    expect(value: new RefundResource(service: resolve('MobilePay')))->toBeInstanceOf(class: RefundResource::class);
});
