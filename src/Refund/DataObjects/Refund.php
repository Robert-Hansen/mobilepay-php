<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Refund\DataObjects;

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Contracts\DataObjectContract;

final class Refund implements DataObjectContract
{
    public function __construct(
        public readonly string $refundId,
        public readonly string $paymentId,
        public readonly int $amount,
        public readonly CarbonImmutable $createdOn,
        public readonly null|string $reference = null,
        public readonly null|string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'refund_id' => $this->refundId,
            'payment_id' => $this->paymentId,
            'amount' => $this->amount,
            'created_on' => $this->createdOn,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
