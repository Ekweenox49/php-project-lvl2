<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\format as formStylish;
use function Differ\Formatters\Plain\format as formPlain;
use function Differ\Formatters\Json\format as formJson;

function format(array $diff, string $formatName): string
{
    switch ($formatName) {
        case 'plain':
            return formPlain($diff);
        case 'json':
            return formJson($diff);
        case 'stylish':
            return formStylish($diff);
        default:
            throw new \Exception("Format '{$formatName}' is not supported. Supported formats: plain, json, stylish.");
    }
}
