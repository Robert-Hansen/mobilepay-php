<?php

use RobertHansen\MobilePay\Tests\TestCase;

uses(TestCase::class)->in('Feature');

function fixture(string $name): array
{
    $file = file_get_contents(
        filename: __DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR . "$name.json",
    );

    if (! $file) {
        throw new InvalidArgumentException(
            message: "Cannot find fixture: [$name] at tests/Fixtures/$name.json",
        );
    }

    return json_decode(
        json: $file,
        associative: true,
    );
}
