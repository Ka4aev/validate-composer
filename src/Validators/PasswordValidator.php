<?php
namespace Validate\Validators;

class PasswordValidator extends AbstractValidator
{
    protected string $message = 'Пароль должен содержать минимум 6 символов, включая цифру, заглавную букву и спецсимвол';

    public function rule(): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s]).{6,}$/', $this->value);
    }
}