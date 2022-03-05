<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Attributes\Strings;

use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Length implements Validator
{
    public function __construct(private ?int $min = null, private ?int $max = null) {}

    public function validate(mixed $value): ValidationResult
    {
        if (!is_null($this->min) && mb_strlen($value) < $this->min) {
            return ValidationResult::invalid("Expected value must be greater than $this->min");
        }

        if (!is_null($this->max) && mb_strlen($value) > $this->max) {
            return ValidationResult::invalid("Expected value must be less than $this->max");
        }

        return ValidationResult::valid();
    }
}
