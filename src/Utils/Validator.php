<?php

namespace KiriminAja\Utils;

use BlakvGhost\PHPValidator\Validator as PHPValidator;

class Validator
{
    /**
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return ValidationResult
     */
    public static function validate(array $inputs, array $rules, array $messages = []): ValidationResult
    {
        $validator = new PHPValidator($inputs, $rules, $messages);
        return new ValidationResult(
            $validator->isValid(),
            $validator->isValid() ? [] : $validator->getErrors()
        );
    }
}
