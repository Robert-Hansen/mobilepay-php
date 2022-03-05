<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Refund\DataObjects;

use DateTimeImmutable;
use RobertHansen\MobilePay\Support\Contracts\DataObjectContract;
use RobertHansen\MobilePay\Support\Enums\Money\Currency;

final class Refund implements DataObjectContract
{
    /**
     * The ID of the refund.
     * @param string $refundId
     *
     * The ID of payment for which refund was issued.
     * @param string $paymentId
     *
     * Merchant ID associated with the refund.
     * @param string $merchantId
     *
     * The payment point on which refunded payment was initiated.
     * @param string $paymentPointId
     *
     * Three-letter ISO currency code, in uppercase. Possible values: DKK or EUR
     * @param Currency $isoCurrencyCode
     *
     * The amount of money refunded. A positive integer representing how much was refunded
     * in the smallest currency unit (e.g., 100 cents to charge €1.00).
     * @param int $amount
     *
     * The timestamp of when the refund was created, in ISO 8601-1:2019 format.
     * Example for July 19th, 2021 14:42:38 Central European Summer Time: UTC: 2021-07-19T12:42:38Z
     * @param DateTimeImmutable $createdOn
     *
     * Refund's reference provided by you.
     * @param string|null $reference
     *
     * Optional refund information to be displayed in MobilePay app to the customer.
     * This can be, for example, an invoice number, ticket number, or short description of the refund.
     * @param string|null $description
     */
    public function __construct(
        public readonly string $refundId,
        public readonly string $paymentId,
        public readonly string $merchantId,
        public readonly string $paymentPointId,
        public readonly Currency $isoCurrencyCode,
        public readonly int $amount,
        public readonly DateTimeImmutable $createdOn,
        public readonly null|string $reference = null,
        public readonly null|string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'refund_id' => $this->refundId,
            'payment_id' => $this->paymentId,
            'merchant_id' => $this->merchantId,
            'payment_point_id' => $this->paymentPointId,
            'iso_currency_code' => $this->isoCurrencyCode->value,
            'amount' => $this->amount,
            'created_on' => $this->createdOn,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
