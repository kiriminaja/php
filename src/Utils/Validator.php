<?php

namespace KiriminAja\Utils;

class Validator
{
    private const MESSAGES = [
        'required' => 'The :attribute field is required.',
        'numeric' => 'The :attribute field must be numeric.',
    ];

    /**
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return ValidationResult
     */
    public static function validate(array $inputs, array $rules, array $messages = []): ValidationResult
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $inputs[$field] ?? null;
            $fieldRules = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($fieldRules as $rule) {
                [$ruleName] = explode(':', $rule, 2);

                if ($ruleName !== 'required' && $value === null) {
                    continue;
                }

                $passes = match ($ruleName) {
                    'required' => !empty($value),
                    'numeric' => is_numeric($value),
                    default => throw new \InvalidArgumentException("Unsupported validation rule: {$ruleName}"),
                };

                if (!$passes) {
                    $errors[$field][] = $messages[$field][$ruleName]
                        ?? str_replace(':attribute', $field, self::MESSAGES[$ruleName]);
                }
            }
        }

        return new ValidationResult(empty($errors), $errors);
    }
}
