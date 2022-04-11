<?php

namespace Differ\Formatters\Json;

function jsonForm($diff)
{
    $result = json_encode($diff, JSON_THROW_ON_ERROR);
    return ("{$result}\n");
}
