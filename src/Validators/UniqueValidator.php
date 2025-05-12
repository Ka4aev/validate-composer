<?php
namespace Validate\Validators;
use Illuminate\Database\Capsule\Manager as Capsule;

class UniqueValidator extends AbstractValidator
{
    protected string $message = 'Поле :field уже занято';
    public function rule(): bool
    {
        return (bool)!Capsule::table($this->args[0])->where($this->args[1], $this->value)->count();
    }
}