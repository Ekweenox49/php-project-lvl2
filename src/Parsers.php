<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($fileData, $format)
{
    switch ($format) {
        case 'yml':
            return  Yaml::parse($fileData);
        case 'json':
            return json_decode($fileData, true);
    }
}
