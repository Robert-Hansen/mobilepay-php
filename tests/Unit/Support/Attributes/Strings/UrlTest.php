<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Attributes\Strings\Url;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\ValidationException;

it('test url is valid', function () {
    $object = new class extends DataTransferObject {
        #[Url]
        public string $url1 = 'https://example.org';
        #[Url]
        public string $url2 = 'http://localhost';
        #[Url]
        public string $url3 = 'myapp://callback';
    };

    expect(value: $object)->not->toThrow(exception: ValidationException::class);
});

it('test invalid url', function () {
    new class extends DataTransferObject {
        #[Url]
        public string $url1 = 'https:://example.org';
        #[Url]
        public string $url2 = 'http:///localhost';
        #[Url]
        public string $url3 = 'myapp://callback-';
    };
})->throws(exception: ValidationException::class);

