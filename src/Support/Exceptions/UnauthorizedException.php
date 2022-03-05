<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Exceptions;

use Illuminate\Http\Client\RequestException;

class UnauthorizedException extends RequestException
{
}
