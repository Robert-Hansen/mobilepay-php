<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Refund\Requests;

use RobertHansen\MobilePay\Support\Attributes\Numbers\NumberBetween;
use RobertHansen\MobilePay\Support\Attributes\Strings\Length;
use RobertHansen\MobilePay\Support\Attributes\Strings\Uuid;
use RobertHansen\MobilePay\Support\Contracts\RequestContract;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateRefundRequest extends DataTransferObject implements RequestContract
{
    public function __construct(
        /**
         * The ID of the payment.
         */
        #[Uuid]
        public string $paymentId,

        /**
         * The amount of money for the payment. A positive integer representing how much the payment is
         * in the smallest currency unit (e.g., 100 cents to charge €1.00).
         * The minimum amount is 1. The maximum amount is defined by user's daily/yearly limits.
         */
        #[NumberBetween(min: 1, max: 2147483647)]
        public int $amount,

        /**
         * A unique value that identifies this InitiatePayment request. Must be a valid UUID,
         * and is used to protect against accidental duplicate calls. Multiple requests with
         * the same idempotency key have the same result.
         */
        #[Uuid]
        public string $idempotencyKey,

        /**
         * Payment's reference provided by you.
         */
        #[Length(max: 64)]
        public string $reference = '',

        /**
         * Optional payment information to be displayed in MobilePay app to the customer.
         * This can be, for example, an invoice number, ticket number.
         */
        #[Length(max: 200)]
        public string $description = '',
    ) {
        parent::__construct(get_defined_vars());
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
