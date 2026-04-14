<?php

namespace KiriminAja\Utils;

use BlakvGhost\PHPValidator\Validator as PHPValidator;

class ValidationResult
{
    private bool $valid;
    private array $errors;

    public function __construct(bool $valid, array $errors = [])
    {
        $this->valid = $valid;
        $this->errors = $errors;
    }

    public function fails(): bool
    {
        return !$this->valid;
    }

    public function passes(): bool
    {
        return $this->valid;
    }

    /**
     * @return array<string>
     */
    public function errors(): array
    {
        $messages = [];
        foreach ($this->errors as $fieldErrors) {
            foreach ((array) $fieldErrors as $msg) {
                $messages[] = $msg;
            }
        }
        return $messages;
    }
}

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
