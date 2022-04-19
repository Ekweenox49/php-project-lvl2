<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\formStylish;
use function Differ\Formatters\Plain\formPlain;
use function Differ\Formatters\Json\formJson;

function formatize(array $diff, string $formatName): string
{
    switch ($formatName) {
        case 'plain':
            return formPlain($diff);
        case 'json':
            return formJson($diff);
        default:
            return formStylish($diff);
    }
}
