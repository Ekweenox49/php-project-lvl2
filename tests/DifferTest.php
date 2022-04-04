<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $expected1 = file_get_contents("testData/result1.txt");
        $this->assertEquals($expected1, genDiff("testData/firstFile.json", "testData/secondFile.json"));

        $expected2 = file_get_contents("testData/result2.txt");
        $this->assertEquals($expected2, genDiff("testData/firstFile.json", "testData/firstFileCopy.json"));
    }
}