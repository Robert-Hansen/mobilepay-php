<?php

declare(strict_types=1);

use RobertHansen\MobilePay\Support\Enums\Http\StatusCode;

it('has reason for each status code', function () {
    $statusCodes = [
        // Informational 1xx
        StatusCode::HTTP_CONTINUE,
        StatusCode::HTTP_SWITCHING_PROTOCOLS,
        StatusCode::HTTP_PROCESSING,
        StatusCode::HTTP_EARLY_HINTS,

        // Successful 2xx
        StatusCode::HTTP_OK,
        StatusCode::HTTP_CREATED,
        StatusCode::HTTP_ACCEPTED,
        StatusCode::HTTP_NON_AUTHORITATIVE_INFORMATION,
        StatusCode::HTTP_NO_CONTENT,
        StatusCode::HTTP_RESET_CONTENT,
        StatusCode::HTTP_PARTIAL_CONTENT,
        StatusCode::HTTP_MULTI_STATUS,
        StatusCode::HTTP_ALREADY_REPORTED,
        StatusCode::HTTP_IM_USED,

        // Redirection 3xx
        StatusCode::HTTP_MULTIPLE_CHOICES,
        StatusCode::HTTP_MOVED_PERMANENTLY,
        StatusCode::HTTP_FOUND,
        StatusCode::HTTP_SEE_OTHER,
        StatusCode::HTTP_NOT_MODIFIED,
        StatusCode::HTTP_USE_PROXY,
        StatusCode::HTTP_TEMPORARY_REDIRECT,
        StatusCode::HTTP_PERMANENTLY_REDIRECT,

        // Client Error 4xx
        StatusCode::HTTP_BAD_REQUEST,
        StatusCode::HTTP_UNAUTHORIZED,
        StatusCode::HTTP_PAYMENT_REQUIRED,
        StatusCode::HTTP_FORBIDDEN,
        StatusCode::HTTP_NOT_FOUND,
        StatusCode::HTTP_METHOD_NOT_ALLOWED,
        StatusCode::HTTP_NOT_ACCEPTABLE,
        StatusCode::HTTP_PROXY_AUTHENTICATION_REQUIRED,
        StatusCode::HTTP_REQUEST_TIMEOUT,
        StatusCode::HTTP_CONFLICT,
        StatusCode::HTTP_GONE,
        StatusCode::HTTP_LENGTH_REQUIRED,
        StatusCode::HTTP_PRECONDITION_FAILED,
        StatusCode::HTTP_REQUEST_ENTITY_TOO_LARGE,
        StatusCode::HTTP_REQUEST_URI_TOO_LONG,
        StatusCode::HTTP_UNSUPPORTED_MEDIA_TYPE,
        StatusCode::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE,
        StatusCode::HTTP_EXPECTATION_FAILED,
        StatusCode::HTTP_I_AM_A_TEAPOT,
        StatusCode::HTTP_MISDIRECTED_REQUEST,
        StatusCode::HTTP_UNPROCESSABLE_ENTITY,
        StatusCode::HTTP_LOCKED,
        StatusCode::HTTP_FAILED_DEPENDENCY,
        StatusCode::HTTP_TOO_EARLY,
        StatusCode::HTTP_UPGRADE_REQUIRED,
        StatusCode::HTTP_PRECONDITION_REQUIRED,
        StatusCode::HTTP_TOO_MANY_REQUESTS,
        StatusCode::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE,
        StatusCode::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS,

        // Server Error 5xx
        StatusCode::HTTP_INTERNAL_SERVER_ERROR,
        StatusCode::HTTP_NOT_IMPLEMENTED,
        StatusCode::HTTP_BAD_GATEWAY,
        StatusCode::HTTP_SERVICE_UNAVAILABLE,
        StatusCode::HTTP_GATEWAY_TIMEOUT,
        StatusCode::HTTP_VERSION_NOT_SUPPORTED,
        StatusCode::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL,
        StatusCode::HTTP_INSUFFICIENT_STORAGE,
        StatusCode::HTTP_LOOP_DETECTED,
        StatusCode::HTTP_NOT_EXTENDED,
        StatusCode::HTTP_NETWORK_AUTHENTICATION_REQUIRED,
    ];

    expect($statusCodes)
        ->toHaveCount(62)
        ->each(fn ($statusCode) => $statusCode->getReason()->toBeString());
});
