<?php

namespace Differ\Formatters\Json;

function formJson(array $diff)
{
    return json_encode($diff, JSON_THROW_ON_ERROR);
}
