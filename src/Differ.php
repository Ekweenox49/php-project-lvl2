<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatter\formatter;

function genDiff($firstFilePath, $secondFilePath, $formatName = 'stylish')
{
    $firstFile = file_get_contents($firstFilePath);
    $secondFile = file_get_contents($secondFilePath);

    $params1 = parse($firstFile, getExtention($firstFilePath));
    $params2 = parse($secondFile, getExtention($secondFilePath));

    $diff = prepareDiff($params1, $params2);

    $result = formatter($diff, $formatName);

    return $result;
}

function prepareDiff($firstData, $secondData)
{
    $keys1 = array_keys(get_object_vars($firstData));
    $keys2 = array_keys(get_object_vars($secondData));

    $unitedKeys = getUnionKeys($keys1, $keys2);

    $diff = array_map(function ($key) use ($firstData, $secondData) {
        if (!property_exists($firstData, $key)) {
            return getDiffRow('added', $key, null, $secondData->$key);
        }

        if (!property_exists($secondData, $key)) {
            return getDiffRow('removed', $key, $firstData->$key, null);
        }

        if (is_object($firstData->$key) && is_object($secondData->$key)) {
            return getDiffRow('object', $key, null, null, prepareDiff($firstData->$key, $secondData->$key));
        }

        if ($firstData->$key === $secondData->$key) {
            return getDiffRow('same', $key, $firstData->$key, $secondData->$key);
        }

        return getDiffRow('changed', $key, $firstData->$key, $secondData->$key);
    }, $unitedKeys);

    return $diff;
}

function getUnionKeys($firstSet, $secondSet)
{
    $union = array_unique(array_merge($firstSet, $secondSet));
    sort($union);
    return $union;
}

function getDiffRow($type, $key, $oldValue, $newValue, $children = null)
{
    return ['type' => $type, 'key' => $key, 'oldValue' => $oldValue, 'newValue' => $newValue, 'children' => $children];
}

function getExtention($filePath)
{
    if (strpos($filePath, ".yml") || strpos($filePath, ".yaml")) {
        return 'yml';
    } else {
        return 'json';
    }
}
