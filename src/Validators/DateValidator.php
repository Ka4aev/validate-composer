<?php
namespace Validate\Validators;

class DateValidator extends AbstractValidator
{
    protected string $message = 'Дата рождения не может быть в будущем';

    public function rule(): bool
    {
        return strtotime($this->value) <= time();
    }
}