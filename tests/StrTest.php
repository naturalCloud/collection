<?php


namespace NaturalCloud\Collection\Test;

use NaturalCloud\Collection\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{


    public function testStrFirst()
    {
        $start = Str::before('@#455', '#');
        $this->assertEquals('@', $start, '应该是: @');
    }
}
