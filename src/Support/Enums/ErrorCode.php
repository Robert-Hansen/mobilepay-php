<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Enums;

enum ErrorCode: string
{
    case PROCESSING_ERROR = 'processing_error';
    case AMOUNT_TO_LARGE = 'amount_too_large';
    case PARTIAL_CAPTURE_DISALLOWED = 'partial_capture_disallowed';
    case PAYMENT_NOT_FOUND = 'payment_not_found';
    case INVALID_PAYMENT_STATE = 'invalid_payment_state';
    case INVALID_PAYMENT_POINT = 'invalid_payment_point';
    case PAYMENT_POINT_NOT_FOUND = 'payment_point_not_found';
    case IDEMPOTENCY_KEY_REUSED = 'idempotency_key_reused';
    case UNAUTHORIZED_ACCESS = 'unauthorized_access';
    case PAYMENT_CAPTURED_WITH_DIFFERENT_AMOUNT = 'payment_captured_with_different_amount';
}
