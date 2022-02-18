<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Payment\DataObjects;

use Carbon\CarbonImmutable;
use RobertHansen\MobilePay\Contracts\DataObjectContract;
use RobertHansen\MobilePay\Payment\Enums\State;

final class Payment implements DataObjectContract
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $paymentPointId,
        public readonly string $merchantId,
        public readonly int $amount,
        public readonly string $mobilePayAppRedirectUri,
        public readonly State $state,
        public readonly string $paymentPointName,
        public readonly string $isoCurrencyCode,
        public readonly CarbonImmutable $initiatedOn,
        public readonly CarbonImmutable $lastUpdatedOn,
        public readonly null|string $reference = null,
        public readonly null|string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->paymentId,
            'payment_point_id' => $this->paymentPointId,
            'merchant_id' => $this->merchantId,
            'amount' => $this->amount,
            'mobilepay_app_redirect_uri' => $this->mobilePayAppRedirectUri,
            'state' => $this->state->value,
            'payment_point_name' => $this->paymentPointName,
            'iso_currency_code' => $this->isoCurrencyCode,
            'initiated_on' => $this->initiatedOn,
            'lastUpdated_on' => $this->lastUpdatedOn,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
