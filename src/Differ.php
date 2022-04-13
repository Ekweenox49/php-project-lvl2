<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatter\formatter;
use function Functional\sort;

function genDiff(string $firstFilePath, string $secondFilePath, string $formatName = 'stylish'): string
{
    $firstFile = file_get_contents($firstFilePath);
    $secondFile = file_get_contents($secondFilePath);

    $params1 = parse($firstFile, getExtention($firstFilePath));
    $params2 = parse($secondFile, getExtention($secondFilePath));

    $diff = prepareDiff($params1, $params2);

    $result = formatter($diff, $formatName);

    return $result;
}

function prepareDiff(object $firstData, object $secondData): array
{
    $keys1 = array_keys(get_object_vars($firstData));
    $keys2 = array_keys(get_object_vars($secondData));

    $unitedKeys = getUnionKeys($keys1, $keys2);

    $diff = array_map(function ($key) use ($firstData, $secondData) {
        if (!property_exists($firstData, $key)) {
            // return getDiffRow('added', $key, null, $secondData->$key);
            return [
                'type' => 'added',
                'key' => $key,
                'oldValue' => null,
                'newValue' => $secondData->$key,
                'children' => null
            ];
        }

        if (!property_exists($secondData, $key)) {
            // return getDiffRow('removed', $key, $firstData->$key, null);
            return [
                'type' => 'removed',
                'key' => $key,
                'oldValue' => $firstData->$key,
                'newValue' => null,
                'children' => null
            ];
        }

        if (is_object($firstData->$key) && is_object($secondData->$key)) {
            // return getDiffRow('object', $key, null, null, prepareDiff($firstData->$key, $secondData->$key));
            $children = prepareDiff($firstData->$key, $secondData->$key);
            return [
                'type' => 'object',
                'key' => $key,
                'oldValue' => null,
                'newValue' => null,
                'children' => $children
            ];
        }

        if ($firstData->$key === $secondData->$key) {
            // return getDiffRow('same', $key, $firstData->$key, $secondData->$key);
            return [
                'type' => 'same',
                'key' => $key,
                'oldValue' => $firstData->$key,
                'newValue' => $secondData->$key,
                'children' => null
            ];
        }

        // return getDiffRow('changed', $key, $firstData->$key, $secondData->$key);
        return [
            'type' => 'changed',
            'key' => $key,
            'oldValue' => $firstData->$key,
            'newValue' => $secondData->$key,
            'children' => null
        ];
    }, $unitedKeys);

    return $diff;
}

function getUnionKeys(array $firstSet, array $secondSet)
{
    $union = array_unique(array_merge($firstSet, $secondSet));
    $sorted = sort($union, fn ($left, $right) => strcmp($left, $right));
    return $sorted;
}

// function getUnionKeys(object $firstData, object $secondData): array
// {
//     $arr1 = get_object_vars($firstData);
//     $arr2 = get_object_vars($secondData);
//     return array_keys(array_merge($arr1, $arr2));
// }

// function getDiffRow($type, $key, $oldValue, $newValue, $children = null): array
// {
//  return ['type' => $type, 'key' => $key, 'oldValue' => $oldValue, 'newValue' => $newValue, 'children' => $children];
// }

function getExtention(string $filePath): string
{
    if (strpos($filePath, ".json") !== false) {
        return 'json';
    } else {
        return 'yml';
    }
}


// $first = '{
//     "host": "hexlet.io",
//     "timeout": 50,
//     "proxy": "123.234.53.22",
//     "follow": false
//   }';

//   $second = '{
//     "timeout": 20,
//     "verbose": true,
//     "host": "hexlet.io"
//   }';

// $first = '../testData/firstFile.json';
// $second = '../testData/secondFile.json';

//   genDiff($first, $second);
