<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\stylishForm;
use function Differ\Formatters\Plane\planeForm;
use function Differ\Formatters\Json\jsonForm;

function formatter($diff, $formatName)
{
    switch ($formatName) {
        case 'plane':
            return planeForm($diff);
        case 'json':
            return jsonForm($diff);
        default:
            return stylishForm($diff);
    }
}
