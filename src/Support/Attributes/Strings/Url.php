<?php

declare(strict_types=1);

namespace RobertHansen\MobilePay\Support\Attributes\Strings;

use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;
use Symfony\Component\Validator\Constraints\Url as ValidateUrl;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Url implements Validator
{
    public function validate(mixed $value): ValidationResult
    {
        $scheme = parse_url($value, PHP_URL_SCHEME);

        $validator = Validation::createValidator();
        $violations = $validator->validate($value, new ValidateUrl(protocols: [$scheme]));

        if ($violations->count() > 0) {
            foreach ($violations as $violation) {
                if ($violation instanceof ConstraintViolation) {
                    return ValidationResult::invalid($violation->getMessage());
                }
            }
        }

        return ValidationResult::valid();
    }
}
