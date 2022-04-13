<?php

namespace Differ\Formatters\Plane;

use function Funct\Collection\flattenAll;

function planeForm($diff)
{
    $iter = function ($diff, $path) use (&$iter) {
        return array_map(function ($node) use ($path, $iter) {
            $fullPath = implode('.', [...$path, $node['key']]);
            $children = $node['children'];

            switch ($node['type']) {
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
                case 'object':
                    return $iter($children, [...$path, $node['key']]);
            }
        }, $diff);
    };
    $result = implode("\n", flattenAll($iter($diff, [])));
    return ("{$result}\n");
}

function getValue($value)
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_object($value)) {
        return '[complex value]';
    }
    return var_export($value, true);
}
