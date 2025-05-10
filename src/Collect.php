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
        // Разбиваем строку валидатора на имя и аргументы
        $validatorParts = explode(':', $validator);
        $validatorName = $validatorParts[0];
        $validatorArgs = $validatorParts[1] ?? null;

        // Формируем полное имя класса валидатора
        $validatorClassName = 'Collect\\Validators\\' . ucfirst($validatorName) . 'Validator';

        // Проверяем существование класса валидатора
        if (!class_exists($validatorClassName)) {
            return;
        }

        // Подготавливаем аргументы
        $args = $validatorArgs ? explode(',', $validatorArgs) : [];

        // Получаем кастомное сообщение об ошибке
        $errorMessage = $messages[$validator] ?? null;

        // Создаем экземпляр валидатора
        $validator = new $validatorClassName(
            $field,               // имя поля
            $this->array[$field] ?? null, // значение поля
            $args,                // дополнительные аргументы
            $errorMessage         // кастомное сообщение
        );

        // Выполняем валидацию и сохраняем ошибку, если есть
        $validationResult = $validator->validate();
        if ($validationResult !== true) {
            $this->errors[$field][] = $validationResult;
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