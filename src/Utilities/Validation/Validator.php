<?php

namespace App\Utilities\Validation;

use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\ValidationException;

class Validator
{
    const BAD_REQUEST = 400;

    /**
     * Validates a value against a set of rules.
     *
     * @param mixed $value The value to validate.
     * @param array $rules The rules to validate against.
     * @param string $fieldName The name of the field being validated.
     * @throws ValidationException If the value fails any of the rules.
     */
    public static function validate($value, $rules, $fieldName)
    {
        foreach ($rules as $rule) {
            self::applyRule($rule, $value, $fieldName);
        }
    }

    /**
     * Applies a single validation rule to a value.
     *
     * @param string $rule The rule to apply.
     * @param mixed $value The value to validate.
     * @param string $fieldName The name of the field being validated.
     * @throws ValidationException If the value fails the rule.
     */
    private static function applyRule($rule, $value, $fieldName)
    {
        switch ($rule) {
            case 'required':
                self::validateRequired($value, $fieldName);
                break;
            case 'numeric':
                self::validateNumeric($value, $fieldName);
                break;
            case 'string':
                self::validateString($value, $fieldName);
                break;
            case 'status_enum':
                self::validateStatusEnum($value, $fieldName);
                break;
            default:
                if (substr($rule, 0, 6) === 'length') {
                    self::validateLength($value, $fieldName, substr($rule, 7));
                }
                break;
        }
    }

    /**
     * Validates that a value exists.
     *
     * @param mixed $value The value to validate.
     * @param string $fieldName The name of the field being validated.
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
     * Validates that a value is numeric.
     *
     * @param mixed $value The value to validate.
     * @param string $fieldName The name of the field being validated.
     * @throws ValidationException If the value is not numeric.
     */
    private static function validateNumeric($value, $fieldName)
    {
        if (!is_numeric($value)) {
            throw new ValidationException(
                sprintf(ErrorCode::NOT_NUMERIC['message'], $fieldName),
                self::BAD_REQUEST
            );
        }
    }

    /**
     * Validates that a value is a string.
     *
     * @param mixed $value The value to validate.
     * @param string $fieldName The name of the field being validated.
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
     * Validates that a value is a valid status.
     *
     * @param mixed $value The value to validate.
     * @param string $fieldName The name of the field being validated.
     * @throws ValidationException If the value is not a valid status.
     */
    private static function validateStatusEnum($value, $fieldName)
    {
        $validStatuses = ['active', 'inactive', 'suspended'];
        if (!in_array($value, $validStatuses)) {
            throw new ValidationException(
                sprintf(ErrorCode::INVALID_STATUS['message'], $fieldName),
                self::BAD_REQUEST
            );
        }
    }

    /**
     * Validates that a value does not exceed a certain length.
     *
     * @param mixed $value The value to validate.
     * @param string $fieldName The name of the field being validated.
     * @param int $length The maximum allowed length.
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
