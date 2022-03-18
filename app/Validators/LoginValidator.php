<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class LoginValidator extends AbstractValidator
{

    protected string $message = 'Логин должен состоять из не менее чем 5 символов и иметь хотя бы одно число в строки';

    public function rule(): bool
    {
        $pattern = '/[a-zA-Z]{5,}\d+/';
        return preg_match($pattern, $this->value);
    }
}
