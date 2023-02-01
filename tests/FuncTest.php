<?php

namespace NaturalCloud\Collection\Test;

use PHPUnit\Framework\TestCase;
use function NaturalCloud\Collection\collect;
use function NaturalCloud\Collection\value;

class FuncTest extends TestCase
{


    public function testCollect()
    {
        $count = collect([
            [
                'index' => 1,
                'name'  => 2,
            ],
            [
                'index' => 3,
                'name'  => 2,
            ],
            [
                'index' => 4,
                'name'  => 2,
            ],
        ])->where('index', '>', 1)->count();

        $this->assertSame(2, $count);
    }
}