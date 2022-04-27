<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider myDataProvider
     */
    public function testGenDiff(string $firstFilePath, string $secondFilePath, string $expectedOutput, string $format)
    {

        $firstFile = $this->getFixturesPath($firstFilePath);
        $secondFile = $this->getFixturesPath($secondFilePath);
        $output = $this->getFixturesPath($expectedOutput);

        $expected = trim(file_get_contents($output));
        $actual = genDiff($firstFile, $secondFile, $format);
        $this->assertEquals($expected, $actual);
    }

    private function getFixturesPath(string $fileName): string
    {
        $dir = 'tests/fixtures/';
        return $dir . $fileName;
    }

    public function myDataProvider()
    {
        return [
            'json files stylish output' => ["firstTree.json", "secondTree.json", "resultStylish.txt", 'stylish'],
            'yaml files stylish output' => ["firstTree.yaml", "secondTree.yaml", "resultStylish.txt", 'stylish'],
            'json files plain output' => ["firstTree.json", "secondTree.json", "resultPlain.txt", 'plain'],
            'yaml files plain output' => ["firstTree.yaml", "secondTree.yaml", "resultPlain.txt", 'plain'],
            'json files json output' => ["firstTree.json", "secondTree.json", "resultJson.txt", 'json'],
            'yaml files json output' => ["firstTree.yaml", "secondTree.yaml", "resultJson.txt", 'json']
        ];
    }
}
