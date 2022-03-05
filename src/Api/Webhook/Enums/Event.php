<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Api\Webhook\Enums;

enum Event: string
{
    /**
     * Published when payment has been approved by MobilePay user and is ready to be captured.
     */
    case PAYMENT_RESERVED = 'payment.reserved';
    /**
     * Published when either initiated payment didn't have any user interactions for 5-10 minutes
     * or payment was reserved, but 7 days have passed and the reservation has expired.
     */
    case PAYMENT_EXPIRED = 'payment.expired';
    /**
     * Published when payment has been cancelled by user inside Mobilepay app.
     */
    case PAYMENT_CANCELLED_BY_USER = 'payment.cancelled_by_user';
    /*
     * Published when newly created payment point is approved and ready to be used. Relevant to integrators.
     */
    case PAYMENT_POINT_ACTIVATED = 'paymentpoint.activated';
}
