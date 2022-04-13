<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\stylishForm;
use function Differ\Formatters\Plane\plainForm;
use function Differ\Formatters\Json\jsonForm;

function formatter(array $diff, string $formatName): string
{
    switch ($formatName) {
        case 'plain':
            return plainForm($diff);
        case 'json':
            return jsonForm($diff);
        case 'stylish':
            return stylishForm($diff);
    }
}
