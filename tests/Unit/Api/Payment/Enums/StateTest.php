<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Api\Payment\Enums\State;

it('has the description of the states', function () {
    $states = [
        State::INITIATED,
        State::RESERVED,
        State::CAPTURED,
        State::CANCELLED_BY_MERCHANT,
        State::CANCELLED_BY_SYSTEM,
        State::CANCELLED_BY_USER,
    ];

    expect($states)
        ->toHaveCount(6)
        ->each(fn ($state) => $state->getDescription()->toBeString());
});
