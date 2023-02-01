<?php

namespace NaturalCloud\Collection\Test;

use NaturalCloud\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{

    public function testWhereEqual()
    {
        $c = new Collection([
            ['id' => 0,],
            ['id' => 4,],
            ['id' => 5,],
            ['id' => 6,],
            ['id' => 9,],
        ]);

        $result = $c->where('id', '>', '5')->values()->toArray();
        $this->assertSame([
            ['id' => 6,],
            ['id' => 9,],
        ], $result, 'testWhereEqual');
    }


    public function testSortBy()
    {
        $data = [
            ['id' => 0,],
            ['id' => 4,],
            ['id' => 5,],
            ['id' => 6,],
            ['id' => 9,],
        ];

        $sortRes = (new Collection($data))->sortBy('id', SORT_REGULAR, true)->values()->toArray();
        $this->assertSame([
            ['id' => 9,],
            ['id' => 6,],
            ['id' => 5,],
            ['id' => 4,],
            ['id' => 0,],
        ], $sortRes, 'testSortBy');
    }


    public function testGroupBy()
    {
        $data = [
            ['id' => 0, 'type' => 1],
            ['id' => 4, 'type' => 2],
            ['id' => 5, 'type' => 2],
            ['id' => 6, 'type' => 1],
            ['id' => 9, 'type' => 3],
        ];

        $sortRes = (new Collection($data))->groupBy('type')->values()->toArray();
        $this->assertSame([
            [
                ['id' => 0, 'type' => 1],
                ['id' => 6, 'type' => 1],
            ],
            [
                ['id' => 4, 'type' => 2],
                ['id' => 5, 'type' => 2],
            ],
            [
                ['id' => 9, 'type' => 3],

            ],
        ], $sortRes, 'testSortBy');
    }
}