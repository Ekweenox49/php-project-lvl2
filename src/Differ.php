<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatter\formatter;
use function Functional\sort;

function genDiff(string $firstFilePath, string $secondFilePath, string $formatName = 'stylish'): string
{
    $firstFile = (string) file_get_contents($firstFilePath);
    $secondFile = (string) file_get_contents($secondFilePath);

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
            return [
                'type' => 'added',
                'key' => $key,
                'oldValue' => null,
                'newValue' => $secondData->$key,
                'children' => null
            ];
        }

        if (!property_exists($secondData, $key)) {
            return [
                'type' => 'removed',
                'key' => $key,
                'oldValue' => $firstData->$key,
                'newValue' => null,
                'children' => null
            ];
        }

        if (is_object($firstData->$key) && is_object($secondData->$key)) {
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
            return [
                'type' => 'same',
                'key' => $key,
                'oldValue' => $firstData->$key,
                'newValue' => $secondData->$key,
                'children' => null
            ];
        }

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

function getExtention(string $filePath): string
{
    if (strpos($filePath, ".json") !== false) {
        return 'json';
    } else {
        return 'yml';
    }
}
