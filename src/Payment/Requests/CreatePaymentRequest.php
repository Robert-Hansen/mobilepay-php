<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Payment\Requests;

final class CreatePaymentRequest
{
    public function __construct(
        public readonly int $amount,
        public readonly string $idempotencyKey,
        public readonly string $paymentPointId,
        public readonly string $redirectUri,
        public readonly string $reference,
        public readonly string $description,
    ) {}

    public function toRequest(): array
    {
        return [
            'amount' => $this->amount,
            'idempotencyKey' => $this->idempotencyKey,
            'paymentPointId' => $this->paymentPointId,
            'redirectUri' => $this->redirectUri,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
