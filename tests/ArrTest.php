<?php


namespace NaturalCloud\Collection\Test;

use NaturalCloud\Collection\Arr;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 * @coversNothing
 */
class ArrTest extends TestCase
{
    public function testArrGet()
    {
        $data = ['id' => 1, 'name' => 'natural_cloud'];
        $this->assertSame(1, Arr::get($data, 'id'));
        $this->assertSame('natural_cloud', Arr::get($data, 'name'));
        $this->assertSame($data, Arr::get($data));
        $this->assertSame(null, Arr::get($data, 'gendar'));
        $this->assertSame(1, Arr::get($data, 'gendar', 1));

        $data = [1, 2, 3, 4];
        $this->assertSame(1, Arr::get($data, 0));
        $this->assertSame(5, Arr::get($data, 4, 5));
        $this->assertSame(null, Arr::get($data, 5));

        $object = new stdClass();
        $object->id = 1;
        $this->assertSame(null, Arr::get($object, 'id'));
    }

    public function testArrSet()
    {
        $data = ['id' => 1, 'name' => 'natural_cloud'];
        Arr::set($data, 'id', 2);
        $this->assertSame(['id' => 2, 'name' => 'natural_cloud'], $data);
        Arr::set($data, 'gendar', 2);
        $this->assertSame(['id' => 2, 'name' => 'natural_cloud', 'gendar' => 2], $data);
        Arr::set($data, 'book.0', 'Hello natural_cloud');
        $this->assertSame(['id' => 2, 'name' => 'natural_cloud', 'gendar' => 2, 'book' => ['Hello natural_cloud']],
            $data);
        Arr::set($data, 'rel.id', 2);
        $this->assertSame([
            'id'     => 2,
            'name'   => 'natural_cloud',
            'gendar' => 2,
            'book'   => ['Hello natural_cloud'],
            'rel'    => ['id' => 2],
        ], $data);
        Arr::set($data, null, [1, 2, 3]);
        $this->assertSame([1, 2, 3], $data);

        $data = [1, 2, 3, 4];
        Arr::set($data, 0, 2);
        $this->assertSame([2, 2, 3, 4], $data);
        Arr::set($data, 4, 2);
        $this->assertSame([2, 2, 3, 4, 2], $data);
    }

    public function testArrMerge()
    {
        $this->assertSame([1, 2, 3, 4], Arr::merge([1, 2, 3], [2, 3, 4]));
        $this->assertSame([1, 2, 3, 2, 3, 4], Arr::merge([1, 2, 3], [2, 3, 4], false));
        $this->assertSame([1, 2, [1, 2], 3, 4], Arr::merge([1, 2, [1, 2]], [[1, 2], 3, 4]));
        $this->assertSame([1, 2, [1, 2], [1, 2], 3, 4], Arr::merge([1, 2, [1, 2]], [[1, 2], 3, 4], false));
        $this->assertSame([1, 2, 3, '2', 4], Arr::merge([1, 2, 3], ['2', 3, 4]));

        $this->assertSame(['id' => 1, 'name' => 'natural_cloud'], Arr::merge(['id' => 1], ['name' => 'natural_cloud']));
        $this->assertSame(['id' => 1, 'name' => 'natural_cloud', 'gender' => 1],
            Arr::merge(['id' => 1, 'name' => 'Swoole'], ['name' => 'natural_cloud', 'gender' => 1]));
        $this->assertSame(['id' => 1, 'ids' => [1, 2, 3], 'name' => 'natural_cloud'],
            Arr::merge(['id' => 1, 'ids' => [1, 2]], ['name' => 'natural_cloud', 'ids' => [1, 2, 3]]));
        $this->assertSame(['id' => 1, 'ids' => [1, 2, 1, 2, 3], 'name' => 'natural_cloud'],
            Arr::merge(['id' => 1, 'ids' => [1, 2]], ['name' => 'natural_cloud', 'ids' => [1, 2, 3]], false));

        $this->assertSame(['id' => 1, 'name' => ['natural_cloud']],
            Arr::merge(['id' => 2], ['id' => 1, 'name' => ['natural_cloud']]));
        $this->assertSame(['id' => 1, 'name' => 'natural_cloud'],
            Arr::merge([], ['id' => 1, 'name' => 'natural_cloud']));
        $this->assertSame([1, 2, 3], Arr::merge([], [1, 2, 3]));
        $this->assertSame([1, 2, 3], Arr::merge([], [1, 2, 2, 3]));
        $this->assertSame([1, 2, [1, 2, 3]], Arr::merge([], [1, 2, 2, [1, 2, 3], [1, 2, 3]]));
        $this->assertSame([1, 2, [1, 2, 3], [1, 2, 3, 4]], Arr::merge([], [1, 2, 2, [1, 2, 3], [1, 2, 3, 4]]));
        $this->assertSame([1, 2, 3], Arr::merge([1, 2], ['id' => 3]));
        $this->assertSame([1, 2, 'id' => 3], Arr::merge([], [1, 2, 'id' => 3]));

    }

    public function testArrayForget()
    {
        $data = [1, 2];
        Arr::forget($data, [1]);
        $this->assertSame([1], $data);

        $data = ['id' => 1, 'name' => 'natural_cloud'];
        Arr::forget($data, ['gender']);
        $this->assertSame(['id' => 1, 'name' => 'natural_cloud'], $data);
        Arr::forget($data, ['id']);
        $this->assertSame(['name' => 'natural_cloud'], $data);

        $data = ['id' => 1, 'name' => 'natural_cloud', 'data' => ['id' => 2], 'data.name' => 'Swoole'];
        Arr::forget($data, ['data.gender']);
        $this->assertSame(['id' => 1, 'name' => 'natural_cloud', 'data' => ['id' => 2], 'data.name' => 'Swoole'],
            $data);
        Arr::forget($data, ['data.name']);
        $this->assertSame(['id' => 1, 'name' => 'natural_cloud', 'data' => ['id' => 2]], $data);
        Arr::forget($data, ['data.id']);
        $this->assertSame(['id' => 1, 'name' => 'natural_cloud', 'data' => []], $data);

        $data = ['data' => ['data' => ['id' => 1, 'name' => 'natural_cloud']]];
        Arr::forget($data, ['data.data.id']);
        $this->assertSame(['data' => ['data' => ['name' => 'natural_cloud']]], $data);

        $data = [1, 2];
        Arr::forget($data, [2]);
        $this->assertSame([1, 2], $data);
    }

    public function testArrMacroable()
    {
        Arr::macro('foo', function () {
            return 'foo';
        });

        $this->assertTrue(Arr::hasMacro('foo'));
        $this->assertFalse(Arr::hasMacro('bar'));
    }
}