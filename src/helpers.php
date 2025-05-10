<?php
namespace Collect;

function collection(array $array = []): Collect
{
    return new Collect($array);
}

function validate(array $data, array $rules, array $messages = []): Collect
{
    return (new Collect($data))->validate($rules, $messages);
}