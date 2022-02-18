<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Payment\DataObjects;

use RobertHansen\MobilePay\Contracts\DataObjectContract;

final class CreatePayment implements DataObjectContract
{
    public function __construct(
        public readonly string $paymentId,
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
