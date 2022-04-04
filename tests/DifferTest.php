<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $expected1 = file_get_contents("tests/fixtures/result1.txt");
        $this->assertEquals($expected1, genDiff("tests/fixtures/firstFile.json", "tests/fixtures/secondFile.json"));

        $expected2 = file_get_contents("tests/fixtures/result2.txt");
        $this->assertEquals($expected2, genDiff("tests/fixtures/firstFile.json", "tests/fixtures/firstFileCopy.json"));
    }
}