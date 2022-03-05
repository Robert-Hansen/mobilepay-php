<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Attributes\Strings;

use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Uuid implements Validator
{
    public function __construct(private bool $nullable = false)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if ($this->nullable === false && is_null($value)) {
            return ValidationResult::invalid("Value is not nullable");
        }

        if (! is_null($value) && ! \Ramsey\Uuid\Uuid::isValid($value)) {
            return ValidationResult::invalid("Value is not a valid UUID");
        }

        return ValidationResult::valid();
    }
}
