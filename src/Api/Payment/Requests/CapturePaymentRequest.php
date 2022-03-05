<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Payment\Requests;

use RobertHansen\MobilePay\Support\Attributes\Numbers\NumberBetween;
use RobertHansen\MobilePay\Support\Contracts\RequestContract;
use Spatie\DataTransferObject\DataTransferObject;

final class CapturePaymentRequest extends DataTransferObject implements RequestContract
{
    public function __construct(
        /**
         * The amount of money for the payment. A positive integer representing how much to capture
         * in the smallest currency unit (e.g., 100 cents to charge €1.00).
         * The minimum amount is 1. The maximum amount is defined by user's daily/yearly limits.
         */
        #[NumberBetween(min: 1, max: 2147483647)]
        public int $amount,
    ) {
        parent::__construct(get_defined_vars());
    }

    public function toRequest(): array
    {
        return [
            'amount' => $this->amount,
        ];
    }
}
