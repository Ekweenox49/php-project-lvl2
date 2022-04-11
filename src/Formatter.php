<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\form as stylishForm;
use function Differ\Formatters\Plane\form as planeForm;

function formatter($diff, $formatName)
{
    switch ($formatName) {
        case 'plane':
            return planeForm($diff);
        default:
            return stylishForm($diff);
    }
}
