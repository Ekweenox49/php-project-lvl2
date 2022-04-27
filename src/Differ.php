<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatter\format;
use function Functional\sort;

function genDiff(string $firstFilePath, string $secondFilePath, string $formatName = 'stylish'): string
{
    $firstFile = getContent($firstFilePath);
    $secondFile = getContent($secondFilePath);

    $parsedFirstFile = parse($firstFile, pathinfo($firstFilePath, PATHINFO_EXTENSION));
    $parsedSecondFile = parse($secondFile, pathinfo($secondFilePath, PATHINFO_EXTENSION));

    $diff = prepareDiff($parsedFirstFile, $parsedSecondFile);

    return format($diff, $formatName);
}

function getContent(string $filePath): string
{
    if (!file_exists($filePath)) {
        throw new \Exception("Can't find {$filePath}.");
    }
    return (string) file_get_contents($filePath);
}

function prepareDiff(object $firstData, object $secondData): array
{
    $keys1 = array_keys(get_object_vars($firstData));
    $keys2 = array_keys(get_object_vars($secondData));

    $union = array_unique(array_merge($keys1, $keys2));
    $sortedKeys = sort($union, fn ($left, $right) => strcmp($left, $right));

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
    }, $sortedKeys);

    return $diff;
}
