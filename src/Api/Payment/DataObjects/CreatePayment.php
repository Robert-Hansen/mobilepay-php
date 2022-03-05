<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Payment\DataObjects;

use RobertHansen\MobilePay\Support\Contracts\DataObjectContract;

final class CreatePayment implements DataObjectContract
{
    public function __construct(
        /**
         * The ID of the payment.
         */
        public readonly string $paymentId,
        /**
         * Deeplink is used to redirect MobilePay users back to the merchant's app.
         */
        public readonly string $mobilePayAppRedirectUri,
    ) {
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->paymentId,
            'mobilepay_app_redirect_uri' => $this->mobilePayAppRedirectUri,
        ];
    }
}
