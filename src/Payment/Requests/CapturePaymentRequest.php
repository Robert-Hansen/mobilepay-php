<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Payment\Requests;

final class CapturePaymentRequest
{
    public function __construct(
        public readonly int $amount,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'amount' => $this->amount,
        ];
    }
}
