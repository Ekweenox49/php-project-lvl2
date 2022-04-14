<?php

namespace Differ\Formatters\Plane;

use function Functional\flatten;

function plainForm(array $diff)
{
    $iter = function (array $diff, array $path) use (&$iter) {
        return array_map(function ($node) use ($path, $iter) {
            $fullPath = implode('.', [...$path, $node['key']]);
            $children = $node['children'];

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
    return implode("\n", flatten($iter($diff, [])));
}

function getValue(mixed $value): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_object($value)) {
        return '[complex value]';
    }
    return var_export($value, true);
}
