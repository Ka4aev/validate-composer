<?php
namespace Collect;

class Collect
{
    private array $array = [];
    private array $errors = [];

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function validate(array $rules, array $messages = []): self
    {
        foreach ($rules as $field => $validators) {
            foreach ($validators as $validator) {
                $this->applyValidator($field, $validator, $messages);
            }
        }
        return $this;
    }

    private function applyValidator(string $field, string $validator, array $messages): void
    {
        $validatorClass = 'Collect\\Validators\\' . ucfirst(explode(':', $validator)[0] . 'Validator');

        if (class_exists($validatorClass)) {
            $args = explode(':', $validator)[1] ?? null;
            $args = $args ? explode(',', $args) : [];

            $validatorInstance = new $validatorClass(
                $field,
                $this->array[$field] ?? null,
                $args,
                $messages[$validator] ?? null
            );

            if ($validatorInstance->validate() !== true) {
                $this->errors[$field][] = $validatorInstance->validate();
            }
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }
}