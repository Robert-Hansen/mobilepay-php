<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Payment\Enums;

enum State: string
{
    case INITIATED = 'initiated';
    case RESERVED = 'reserved';
    case CAPTURED = 'captured';
    case CANCELLED_BY_MERCHANT = 'cancelledByMerchant';
    case CANCELLED_BY_SYSTEM = 'cancelledBySystem';
    case CANCELLED_BY_USER = 'cancelledByUser';

    public function description(): string
    {
        return match ($this) {
            self::INITIATED => 'initial state.',
            self::RESERVED => 'MobilePay user approved payment, ready to be captured.',
            self::CAPTURED => 'final state, funds will be transferred during next settlement.',
            self::CANCELLED_BY_MERCHANT => 'payment was cancelled by you.',
            self::CANCELLED_BY_SYSTEM => 'no user interactions with payment were made in 5-10 minutes after creation, so our automated job cancelled it.',
            self::CANCELLED_BY_USER => 'user cancelled payment inside MobilePay app.',
        };
    }
}
