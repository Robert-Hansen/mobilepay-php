<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Attributes\Strings\Length;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('test value is within min and max length', function () {
    $object = new class extends DataTransferObject {
        #[Length(min: 1, max: 10)]
        public string $name = 'Jane';
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test only setting min length', function () {
    $object = new class extends DataTransferObject {
        #[Length(min: 1)]
        public string $name = 'Jane';
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test only setting max length', function () {
    $object = new class extends DataTransferObject {
        #[Length(max: 10)]
        public string $name = 'Jane';
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test value is not within min and max length', function () {
    new class extends DataTransferObject {
        #[Length(min: 5, max: 10)]
        public string $name = 'Jane';
    };
})->throws(exception: ValidationException::class);

