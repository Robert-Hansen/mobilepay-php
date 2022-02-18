<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Webhook\Enums;

enum Event: string
{
    case PAYMENT_RESERVED = 'payment.reserved';
    case PAYMENT_EXPIRED = 'payment.expired';
    case PAYMENT_POINT_ACTIVATED = 'paymentpoint.activated';
}
