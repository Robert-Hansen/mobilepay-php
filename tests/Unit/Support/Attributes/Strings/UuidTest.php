<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Attributes\Strings\Uuid;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('test uuid is valid', function () {
    $object = new class () extends DataTransferObject {
        #[Uuid]
        public string $id = '655ad36f-70b0-4add-a123-b943daca50e8';
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test uuid is nullable', function () {
    $object = new class () extends DataTransferObject {
        #[Uuid(nullable: true)]
        public ?string $id = null;
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test uuid is not nullable', function () {
    new class () extends DataTransferObject {
        #[Uuid(nullable: false)]
        public ?string $id = null;
    };
})->throws(exception: ValidationException::class);

it('test invalid uuid', function () {
    new class () extends DataTransferObject {
        #[Uuid]
        public string $id = '5ad36f-70b0-4add-a123-b9430e';
    };
})->throws(exception: ValidationException::class);
