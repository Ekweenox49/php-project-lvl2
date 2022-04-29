<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider formatProvider
     */
    public function testGenDiffStylish(string $firstFilePath, string $secondFilePath)
    {

        $firstFile = $this->getFixturesPath($firstFilePath);
        $secondFile = $this->getFixturesPath($secondFilePath);
        $output = $this->getFixturesPath('resultStylish.txt');

        $expected = trim(file_get_contents($output));
        $actual = genDiff($firstFile, $secondFile, 'stylish');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider formatProvider
     */
    public function testGenDiffPlain(string $firstFilePath, string $secondFilePath)
    {

        $firstFile = $this->getFixturesPath($firstFilePath);
        $secondFile = $this->getFixturesPath($secondFilePath);
        $output = $this->getFixturesPath('resultPlain.txt');

        $expected = trim(file_get_contents($output));
        $actual = genDiff($firstFile, $secondFile, 'plain');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider formatProvider
     */
    public function testGenDiffJson(string $firstFilePath, string $secondFilePath)
    {

        $firstFile = $this->getFixturesPath($firstFilePath);
        $secondFile = $this->getFixturesPath($secondFilePath);
        $output = $this->getFixturesPath('resultJson.txt');

        $expected = trim(file_get_contents($output));
        $actual = genDiff($firstFile, $secondFile, 'json');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider formatProvider
     */
    public function testGenDiffDefault(string $firstFilePath, string $secondFilePath)
    {

        $firstFile = $this->getFixturesPath($firstFilePath);
        $secondFile = $this->getFixturesPath($secondFilePath);
        $output = $this->getFixturesPath('resultStylish.txt');

        $expected = trim(file_get_contents($output));
        $actual = genDiff($firstFile, $secondFile);
        $this->assertEquals($expected, $actual);
    }

    private function getFixturesPath(string $fileName): string
    {
        $dir = 'tests/fixtures/';
        return $dir . $fileName;
    }

    public function formatProvider()
    {
        return [
            'json input' => ["firstTree.json", "secondTree.json"],
            'yaml input' => ["firstTree.yaml", "secondTree.yaml"]
        ];
    }
}
