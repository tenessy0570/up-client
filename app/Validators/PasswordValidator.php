<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class PasswordValidator extends AbstractValidator
{

    protected string $message = 'Пароль должен содержать не менее 8 символов!';

    public function rule(): bool
    {
        return strlen($this->value) >= 8;
    }
}
