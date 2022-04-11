<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $expected1 = file_get_contents("tests/fixtures/resultTree.txt");
        $this->assertEquals($expected1, genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json"));

        $expected2 = file_get_contents("tests/fixtures/result1.txt");
        $this->assertEquals($expected2, genDiff("tests/fixtures/firstFile.yaml", "tests/fixtures/secondFile.yaml"));

        $expected3 = file_get_contents("tests/fixtures/resultPlane.txt");
        $this->assertEquals($expected3, genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", 'plane'));

        $expected4 = file_get_contents("tests/fixtures/resultJson.txt");
        $this->assertEquals($expected4, genDiff("tests/fixtures/firstTree.json", "tests/fixtures/secondTree.json", 'json'));
    }
}