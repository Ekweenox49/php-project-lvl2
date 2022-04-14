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
        $this->assertSame($expected1, "{$actual1}\n");

        $expected2 = file_get_contents("tests/fixtures/result1.txt");
        $actual2 = genDiff("tests/fixtures/firstFile.yaml", "tests/fixtures/secondFile.yaml");
        $this->assertSame($expected2, "{$actual2}\n");

        $expected3 = file_get_contents("tests/fixtures/resultPlane.txt");
        $actual3 = genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", 'plain');
        $this->assertSame($expected3, "{$actual3}\n");

        $expected4 = file_get_contents("tests/fixtures/resultJson.txt");
        $actual4 = genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", 'json');
        $this->assertSame($expected4, "{$actual4}\n");
    }
}
