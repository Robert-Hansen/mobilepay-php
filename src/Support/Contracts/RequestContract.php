<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Contracts;

interface RequestContract
{
    public function toRequest(): array;
}
