<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider myDataProvider
     */
    public function testGenDiff(string $firstFilePath, string $secondFilePath, string $expectedOutput, string $format = '')
    {
        $expected = file_get_contents($expectedOutput);
        $actual = genDiff($firstFilePath, $secondFilePath, $format);
        $this->assertEquals($expected, "{$actual}\n");
    }

    public function myDataProvider()
    {
        return [
            'json files stylish output' => ["tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", "tests/fixtures/resultStylish.txt"],
            'yaml files stylish output' => ["tests/fixtures/firstTree.yaml", "tests/fixtures/secondTree.yaml", "tests/fixtures/resultStylish.txt"],
            'json files plain output' => ["tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", "tests/fixtures/resultPlain.txt", 'plain'],
            'json files json output' => ["tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", "tests/fixtures/resultJson.txt", 'json']
        ];
    }
}
