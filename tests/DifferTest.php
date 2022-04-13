<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $expected1 = file_get_contents("tests/fixtures/resultTree.txt");
        $actual1 = genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json");
        $this->assertEquals($expected1, "{$actual1}\n");

        $expected2 = file_get_contents("tests/fixtures/result1.txt");
        $actual2 = genDiff("tests/fixtures/firstFile.yaml", "tests/fixtures/secondFile.yaml");
        $this->assertEquals($expected2, "{$actual2}\n");

        $expected3 = file_get_contents("tests/fixtures/resultPlane.txt");
        $actual3 = genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", 'plane');
        $this->assertEquals($expected3, "{$actual3}\n");

        $expected4 = file_get_contents("tests/fixtures/resultJson.txt");
        $actual4 = genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", 'json');
        $this->assertEquals($expected4, "{$actual4}\n");
    }
}