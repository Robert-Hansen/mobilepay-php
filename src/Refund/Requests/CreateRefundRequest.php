<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Refund\Requests;

final class CreateRefundRequest
{
    public function __construct(
        public readonly string $paymentId,
        public readonly int $amount,
        public readonly string $idempotencyKey,
        public readonly string $reference,
        public readonly string $description,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'paymentId' => $this->paymentId,
            'amount' => $this->amount,
            'idempotencyKey' => $this->idempotencyKey,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
