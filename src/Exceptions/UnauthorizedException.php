<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Exceptions;

use Illuminate\Http\Client\RequestException;

class UnauthorizedException extends RequestException
{
}