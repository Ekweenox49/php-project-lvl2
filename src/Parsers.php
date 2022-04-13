<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $fileData, string $format)
{
    switch ($format) {
        case 'yml':
            return  Yaml::parse($fileData, Yaml::PARSE_OBJECT_FOR_MAP);
        case 'json':
            return json_decode($fileData);
    }
}
