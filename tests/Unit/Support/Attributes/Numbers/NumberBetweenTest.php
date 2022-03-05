<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Attributes\Numbers\NumberBetween;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('test number must be between defined min and max', function () {
    $object = new class () extends DataTransferObject {
        #[NumberBetween(min: 1, max: 10)]
        public int $points = 5;
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test number is not between defined min and max', function () {
    new class () extends DataTransferObject {
        #[NumberBetween(min: 1, max: 10)]
        public int $points = 20;
    };
})->throws(exception: ValidationException::class);
