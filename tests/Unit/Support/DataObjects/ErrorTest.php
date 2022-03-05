<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Enums\ErrorCode;
use RobertHansen\MobilePay\Support\DataObjects\Error;

it('can build error data object', function () {
    $dataObject = new Error(
        code: ErrorCode::INVALID_PAYMENT_STATE,
        correlationId: '8d4243bc-aa83-43c3-a55d-5da221facd9b',
        message: 'Cannot cancel payment that is already captured.',
        origin: 'MPY',
    );

    expect($dataObject)
        ->toBeInstanceOf(Error::class)
        ->toHaveProperties(names: [
            'code',
            'correlationId',
            'message',
            'origin',
        ])
        ->code->toBeInstanceOf(ErrorCode::class)
        ->correlationId->toBeString()
        ->message->toBeString()
        ->origin->toBeString();
});

it('can build error data object convert it to array', function () {
    $dataObject = new Error(
        code: ErrorCode::INVALID_PAYMENT_STATE,
        correlationId: '8d4243bc-aa83-43c3-a55d-5da221facd9b',
        message: 'Cannot cancel payment that is already captured.',
        origin: 'MPY',
    );

    expect($dataObject->toArray())
        ->toBeArray()
        ->toHaveKeys(keys: [
            'code',
            'correlation_id',
            'message',
            'origin',
        ]);
});

