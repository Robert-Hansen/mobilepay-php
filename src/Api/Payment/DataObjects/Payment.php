<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Payment\DataObjects;

use DateTimeImmutable;
use RobertHansen\MobilePay\Api\Payment\Enums\State;
use RobertHansen\MobilePay\Support\Contracts\DataObjectContract;
use RobertHansen\MobilePay\Support\Enums\Money\Currency;

final class Payment implements DataObjectContract
{
    /**
     * The ID of the payment.
     * @param string $paymentId
     *
     * The payment point on which the payment was initiated.
     * @param string $paymentPointId
     *
     * Merchant ID associated with the payment.
     * @param string $merchantId
     *
     * The amount of money for the payment. A positive integer representing how much was the payment is
     * in the smallest currency unit (e.g., 100 cents to charge €1.00).
     * The minimum amount is 1. The maximum amount is defined by user's daily/yearly limits.
     * @param int $amount
     *
     * Deeplink is used to redirect MobilePay users back to the merchant's app.
     * @param string $mobilePayAppRedirectUri
     *
     * Indicates whether the payment is "initiated", "reserved", "captured",
     * "cancelledByMerchant", "cancelledBySystem", "cancelledByUser".
     * @param State $state
     *
     * Payment point name displayed to the user in MobilePay app.
     * @param string $paymentPointName
     *
     * Three-letter ISO currency code, in uppercase. Possible values: DKK or EUR
     * @param Currency $isoCurrencyCode
     *
     * The timestamp of when the payment was created, in ISO 8601-1:2019 format.
     * Example for July 19th, 2021 14:42:38 Central European Summer Time: UTC: 2021-07-19T12:42:38Z
     * @param DateTimeImmutable $initiatedOn
     *
     * The timestamp of when the payment was last updated, in ISO 8601-1:2019 format.
     * Example for July 19th, 2021 14:42:38 Central European Summer Time: UTC: 2021-07-19T12:42:38Z
     * @param DateTimeImmutable $lastUpdatedOn
     *
     * Payment's reference provided by you.
     * @param string|null $reference
     *
     * Optional payment information to be displayed in MobilePay app to the customer.
     * This can be, for example, an invoice number, ticket number.
     * @param string|null $description
     */
    public function __construct(
        public readonly string $paymentId,
        public readonly string $paymentPointId,
        public readonly string $merchantId,
        public readonly int $amount,
        public readonly string $mobilePayAppRedirectUri,
        public readonly State $state,
        public readonly string $paymentPointName,
        public readonly Currency $isoCurrencyCode,
        public readonly DateTimeImmutable $initiatedOn,
        public readonly DateTimeImmutable $lastUpdatedOn,
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
            'iso_currency_code' => $this->isoCurrencyCode->value,
            'initiated_on' => $this->initiatedOn,
            'last_updated_on' => $this->lastUpdatedOn,
            'reference' => $this->reference,
            'description' => $this->description,
        ];
    }
}
