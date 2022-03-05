<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\DataObjects;

use RobertHansen\MobilePay\Support\Contracts\DataObjectContract;
use RobertHansen\MobilePay\Support\Enums\ErrorCode;

final class Error implements DataObjectContract
{
    public function __construct(
        public readonly ErrorCode|null $code,
        public readonly string $correlationId,
        public readonly string $message,
        public readonly string $origin,
    ) {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code?->value,
            'correlation_id' => $this->correlationId,
            'message' => $this->message,
            'origin' => $this->origin,
        ];
    }
}
