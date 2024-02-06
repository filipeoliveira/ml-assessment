<?php

namespace App\Utilities\Validation;

use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\ValidationException;

class Validator
{
    const BAD_REQUEST = 400;

    /**
     * Validates an array of values against a set of rules.
     *
     * @param  array $values The values to validate.
     * @param  array $rules  The rules to validate against.
     * @throws ValidationException If any value fails any of its rules.
     */
    public static function validate($values, $rules)
    {
        foreach ($rules as $fieldName => $fieldRules) {
            if (!isset($values[$fieldName])) {
                throw new ValidationException(
                    sprintf(ErrorCode::MISSING_VALUE['message'], $fieldName),
                    self::BAD_REQUEST
                );
            }

            $value = $values[$fieldName];
            foreach ($fieldRules as $rule) {
                self::applyRule($rule, $value, $fieldName);
            }
        }
    }

    /**
     * Applies a single validation rule to a value.
     *
     * @param  string $rule      The rule to apply.
     * @param  mixed  $value     The value to validate.
     * @param  string $fieldName The name of the field being validated.
     * @throws ValidationException If the value fails the rule.
     */
    private static function applyRule($rule, $value, $fieldName)
    {
        switch ($rule) {
            case 'required':
                self::validateRequired($value, $fieldName);
                break;
            case 'string':
                self::validateString($value, $fieldName);
                break;
            case 'email':
                self::validateEmail($value, $fieldName);
                break;
            default:
                if (strpos($rule, 'length:') === 0) {
                    self::validateLength($value, $fieldName, substr($rule, 7));
                }
                break;
        }
    }

    /**
     * Validates that a value exists.
     *
     * @param  mixed  $value     The value to validate.
     * @param  string $fieldName The name of the field being validated.
     * @throws ValidationException If the value does not exist.
     */
    private static function validateRequired($value, $fieldName)
    {
        if (!isset($value)) {
            throw new ValidationException(
                sprintf(ErrorCode::MISSING_VALUE['message'], $fieldName),
                self::BAD_REQUEST
            );
        }
    }

    /**
     * Validates that a value is a string.
     *
     * @param  mixed  $value     The value to validate.
     * @param  string $fieldName The name of the field being validated.
     * @throws ValidationException If the value is not a string.
     */
    private static function validateString($value, $fieldName)
    {
        if (!is_string($value)) {
            throw new ValidationException(
                sprintf(ErrorCode::NOT_STRING['message'], $fieldName),
                self::BAD_REQUEST
            );
        }
    }

    /**
     * Validates that a value is a valid email address.
     *
     * @param  mixed  $value     The value to validate.
     * @param  string $fieldName The name of the field being validated.
     * @throws ValidationException If the value is not a valid email address.
     */
    private static function validateEmail($value, $fieldName)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException(
                sprintf(ErrorCode::INVALID_EMAIL['message'], $fieldName),
                self::BAD_REQUEST
            );
        }
    }

    /**
     * Validates that a value does not exceed a certain length.
     *
     * @param  mixed  $value     The value to validate.
     * @param  string $fieldName The name of the field being validated.
     * @param  int    $length    The maximum allowed length.
     * @throws ValidationException If the value exceeds the maximum length.
     */
    private static function validateLength($value, $fieldName, $length)
    {
        if (strlen($value) > $length) {
            throw new ValidationException(
                sprintf(ErrorCode::LENGTH_EXCEEDED['message'], $fieldName),
                self::BAD_REQUEST
            );
        }
    }
}
