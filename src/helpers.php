<?php
namespace Validate;

function collection(array $array = []): Validate
{
    return new Validate($array);
}

function validate(array $data, array $rules, array $messages = []): Validate
{
    return (new Validate($data))->validate($rules, $messages);
}