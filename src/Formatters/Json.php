<?php

namespace Differ\Formatters\Json;

function jsonForm(array $diff)
{
    return json_encode($diff, JSON_THROW_ON_ERROR);
}
