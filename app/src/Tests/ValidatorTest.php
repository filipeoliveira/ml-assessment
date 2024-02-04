<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Utilities\Validation\Validator;
use App\Utilities\Exceptions\ValidationException;
use App\Utilities\Errors\ErrorCode;

class ValidatorTest extends TestCase
{
    public function testValidateRequired()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionCode(Validator::BAD_REQUEST);
        $this->expectExceptionMessage(sprintf(ErrorCode::MISSING_VALUE['message'], 'field'));
        Validator::validate([], ['field' => ['required']]);
    }

    public function testValidateString()
    {
        $this->expectException(ValidationException::class);
        Validator::validate(['field' => 123], ['field' => ['string']]);
    }

    public function testValidateEmail()
    {
        $this->expectException(ValidationException::class);
        Validator::validate(['field' => 'not an email'], ['field' => ['email']]);
    }

    public function testValidateLength()
    {
        $this->expectException(ValidationException::class);
        Validator::validate(['field' => 'too long'], ['field' => ['length:5']]);
    }

    public function testValidateSuccess()
    {
        $this->expectNotToPerformAssertions();
        Validator::validate(['field' => 'valid@email.com'], ['field' => ['required', 'string', 'email', 'length:15']]);
    }
}