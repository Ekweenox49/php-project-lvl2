<?php

namespace Differ\Differ;

function genDiff($firstFilePath, $secondFilePath) 
{
    $firstFile = file_get_contents($firstFilePath);
    $secondFile = file_get_contents($secondFilePath);

    $params1 = json_decode($firstFile, true);
    $params2 = json_decode($secondFile, true);
    // print_r($params1);
    // print_r($params2);

    $keys1 = array_keys($params1);
    $keys2 = array_keys($params2);

    $union = array_unique(array_merge($keys1, $keys2));

    // print_r($union);
    
    sort($union);

    $resultRows = [];

    foreach ($union as $key) {
        if (isset($params1[$key]) && isset($params2[$key])) {
            if ($params1[$key] == $params2[$key]) {
                $resultRows[] = makeRow('non-changed', $key, $params1[$key], $params2[$key]);
            } else {
                $resultRows[] = makeRow('changed', $key, $params1[$key], $params2[$key]);
            }
        }

        if (isset($params1[$key]) && !isset($params2[$key])) {
            $resultRows[] = makeRow('missed', $key, $params1[$key], null);
        }

        if (!isset($params1[$key]) && isset($params2[$key])) {
            $resultRows[] = makeRow('added', $key, null, $params2[$key]);
        }
    }

    // print_r($resultRows);

    $result = implode("\n", $resultRows);

    $output = "{\n" . $result . "\n}\n";

    // print_r($output);

    return $output;
}

function makeRow($type, $key, $oldValue, $newValue) {
    switch ($type) {
        case 'added':
            return $row = "  + {$key}: {$newValue}";

        case 'missed':
            return $row = "  - " . $key . ": " . $oldValue;

        case 'non-changed':
            return $row = "    " . $key . ": " . $newValue;

        case 'changed':
            // return $row = "- " . $key . ": " . $oldValue;
            return $row = "  - " . $key . ": " . $oldValue . "\n  + " . $key . ": " . $newValue;
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