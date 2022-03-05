<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Attributes\Numbers\GreaterThan;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('test value is greater than the value set', function () {
    $object = new class () extends DataTransferObject {
        #[GreaterThan(value: 1)]
        public int $amount = 5;
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test value is less than the value set', function () {
    new class () extends DataTransferObject {
        #[GreaterThan(value: 10)]
        public int $amount = 1;
    };
})->throws(exception: ValidationException::class);
