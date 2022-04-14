<?php

namespace Differ\Formatters\Stylish;

use function Functional\flatten;

function stylishForm(array $diff)
{
    $iter = function (array $diff, int $depth) use (&$iter) {
        return array_map(function ($node) use ($depth, $iter) {

            $children = $node['children'];

            $indent = formIndent($depth - 1);

            switch ($node['type']) {
                case 'object':
                    $closingBracketIndent = formIndent($depth);
                    return ["{$indent}    {$node['key']}: {", $iter($children, $depth + 1), "{$closingBracketIndent}}"];
                case 'added':
                    $newRow = formRow($node['newValue'], $depth);
                    return "{$indent}  + {$node['key']}: {$newRow}";
                case 'removed':
                    $oldRow = formRow($node['oldValue'], $depth);
                    return "{$indent}  - {$node['key']}: {$oldRow}";
                case 'same':
                    $newRow = formRow($node['newValue'], $depth);
                    return "{$indent}    {$node['key']}: {$newRow}";
                case 'changed':
                    $oldRow = formRow($node['oldValue'], $depth);
                    $newRow = formRow($node['newValue'], $depth);
                    $addedRow = "{$indent}  + {$node['key']}: {$newRow}";
                    $deletedRow = "{$indent}  - {$node['key']}: {$oldRow}";
                    return implode("\n", [$deletedRow, $addedRow]);
            };
        }, $diff);
    };
    $result = implode("\n", flatten($iter($diff, 1)));
    return ("{\n{$result}\n}");
}

function formIndent(int $depth): string
{
    return str_repeat(" ", 4 * $depth);
}

function formRow($value, int $depth): string
{
    if (!is_object($value)) {
        return toString($value);
    }

    $keys = array_keys(get_object_vars($value));
    $indent = formIndent($depth);

    $lines = array_map(function ($key) use ($value, $depth, $indent) {
        $childrenValue = formRow($value->$key, $depth + 1);
            return "{$indent}    {$key}: {$childrenValue}";
    }, $keys);

    $result = implode("\n", $lines);
    return "{\n{$result}\n{$indent}}";
}

function toString($value)
{
    if (is_null($value)) {
        return 'null';
    }
    return trim(var_export($value, true), "'");
}
