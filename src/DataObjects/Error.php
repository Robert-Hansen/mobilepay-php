<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\DataObjects;

use RobertHansen\MobilePay\Contracts\DataObjectContract;
use RobertHansen\MobilePay\Payment\Enums\ErrorCode;

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
            'code' => $this->code,
            'correlation_id' => $this->correlationId,
            'message' => $this->message,
            'origin' => $this->origin,
        ];
    }
}
