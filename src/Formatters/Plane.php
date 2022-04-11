<?php

namespace Differ\Formatters\Plane;

use function Funct\Collection\flattenAll;

function form(array $diff)
{
    $iter = function ($diff, $path) use (&$iter): array {
        return array_map(function ($node) use ($path, $iter) {
            $children = $node['children'];

            $fullPath = implode('.', [...$path, $node['key']]);

            switch ($node['type']) {
                case 'object':
                    return $iter($children, [...$path, $node['key']]);
                case 'added':
                    $newValue = getValue($node['newValue']);
                    return "Property '{$fullPath}' was added with value: {$newValue}";
                case 'removed':
                    return "Property '{$fullPath}' was removed";
                case 'same':
                    return [];
                case 'changed':
                    $oldValue = getValue($node['oldValue']);
                    $newValue = getValue($node['newValue']);
                    return "Property '{$fullPath}' was updated. From {$oldValue} to {$newValue}";
            }
        }, $diff);
    };
    $result = implode("\n", flattenAll($iter($diff, [])));
    return ("{$result}\n");
}

function getValue($value): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_object($value)) {
        return '[complex value]';
    }
    return var_export($value, true);
}
