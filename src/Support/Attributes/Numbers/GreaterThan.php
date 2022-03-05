<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Attributes\Numbers;

use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class GreaterThan implements Validator
{
    public function __construct(private int $value)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if ($value < $this->value) {
            return ValidationResult::invalid("Value must be greater than {$this->value}");
        }

        return ValidationResult::valid();
    }
}
