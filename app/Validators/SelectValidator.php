<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class SelectValidator extends AbstractValidator
{

    protected string $message = 'Выберите :field';

    public function rule(): bool
    {
        return $this->value !== 'fake';
    }
}
