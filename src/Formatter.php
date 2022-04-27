<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\format as stylish;
use function Differ\Formatters\Plain\format as plain;
use function Differ\Formatters\Json\format as json;

function format(array $diff, string $formatName): string
{
    switch ($formatName) {
        case 'plain':
            return plain($diff);
        case 'json':
            return json($diff);
        case 'stylish':
            return stylish($diff);
        default:
            throw new \Exception("Format '{$formatName}' is not supported. Supported formats: plain, json, stylish.");
    }
}
