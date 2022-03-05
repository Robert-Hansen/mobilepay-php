<?php

use RobertHansen\MobilePay\Tests\TestCase;

uses(TestCase::class)->in('Feature');
uses(TestCase::class)->in('Unit');

function fixture(string|null $folder, string $name): array
{
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;

    if (! is_null($folder)) {
        $path .= $folder . DIRECTORY_SEPARATOR;
    }

    $file = file_get_contents(filename: $path . "$name.json");

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
