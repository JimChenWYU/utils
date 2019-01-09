<?php

/*
 * This file is part of the jimchen/utils.
 *
 * (c) JimChen <18219111672@163.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace JimChen\Utils\Tests;

use JimChen\Utils\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function testAdd()
    {
        $array = Arr::add(['name' => 'Desk'], 'price', 100);
        $this->assertSame(['name' => 'Desk', 'price' => 100], $array);
    }

    public function testDivide()
    {
        list($keys, $values) = Arr::divide(['name' => 'Desk']);
        $this->assertSame(['name'], $keys);
        $this->assertSame(['Desk'], $values);
    }

    public function testDot()
    {
        $array = Arr::dot(['foo' => ['bar' => 'baz']]);
        $this->assertSame(['foo.bar' => 'baz'], $array);
    }

    public function testExcept()
    {
        $array = ['name' => 'Desk', 'price' => 100];
        $array = Arr::except($array, ['price']);
        $this->assertSame(['name' => 'Desk'], $array);
    }

    public function testFirst()
    {
        $array = [100, 200, 300];
        $value = Arr::first($array, function ($key, $value) {
            return $value >= 150;
        });
        $this->assertSame(200, $value);
    }

    public function testLast()
    {
        $array = [100, 200, 300];
        $last = Arr::last($array, function () {
            return true;
        });
        $this->assertSame(300, $last);
    }

    public function testFlatten()
    {
        $array = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby']];
        $array = Arr::flatten($array);
        $this->assertSame(['Joe', 'PHP', 'Ruby'], $array);
    }

    public function testGet()
    {
        $array = ['products' => ['desk' => ['price' => 100]]];
        $value = Arr::get($array, 'products.desk');
        $this->assertSame(['price' => 100], $value);
    }

    public function testHas()
    {
        $array = ['products' => ['desk' => ['price' => 100]]];
        $this->assertTrue(Arr::has($array, 'products.desk'));
        $this->assertTrue(Arr::has($array, 'products.desk.price'));
        $this->assertFalse(Arr::has($array, 'products.foo'));
        $this->assertFalse(Arr::has($array, 'products.desk.foo'));
    }

    public function testIsAssoc()
    {
        $this->assertTrue(Arr::isAssoc(['a' => 'a', 0 => 'b']));
        $this->assertTrue(Arr::isAssoc([1 => 'a', 0 => 'b']));
        $this->assertTrue(Arr::isAssoc([1 => 'a', 2 => 'b']));
        $this->assertFalse(Arr::isAssoc([0 => 'a', 1 => 'b']));
        $this->assertFalse(Arr::isAssoc(['a', 'b']));
    }

    public function testOnly()
    {
        $array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];
        $array = Arr::only($array, ['name', 'price']);
        $this->assertSame(['name' => 'Desk', 'price' => 100], $array);
    }

    public function testPluck()
    {
        $array = [
            ['developer' => ['name' => 'Taylor']],
            ['developer' => ['name' => 'Abigail']],
        ];
        $array = Arr::pluck($array, 'developer.name');
        $this->assertSame(['Taylor', 'Abigail'], $array);
    }

    public function testPluckWithKeys()
    {
        $array = [
            ['name' => 'Taylor', 'role' => 'developer'],
            ['name' => 'Abigail', 'role' => 'developer'],
        ];
        $test1 = Arr::pluck($array, 'role', 'name');
        $test2 = Arr::pluck($array, null, 'name');
        $this->assertSame([
            'Taylor' => 'developer',
            'Abigail' => 'developer',
        ], $test1);
        $this->assertSame([
            'Taylor' => ['name' => 'Taylor', 'role' => 'developer'],
            'Abigail' => ['name' => 'Abigail', 'role' => 'developer'],
        ], $test2);
    }

    public function testPrepend()
    {
        $array = Arr::prepend(['one', 'two', 'three', 'four'], 'zero');
        $this->assertSame(['zero', 'one', 'two', 'three', 'four'], $array);
        $array = Arr::prepend(['one' => 1, 'two' => 2], 0, 'zero');
        $this->assertSame(['zero' => 0, 'one' => 1, 'two' => 2], $array);
    }

    public function testPull()
    {
        $array = ['name' => 'Desk', 'price' => 100];
        $name = Arr::pull($array, 'name');
        $this->assertSame('Desk', $name);
        $this->assertSame(['price' => 100], $array);
    }

    public function testSet()
    {
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::set($array, 'products.desk.price', 200);
        $this->assertSame(['products' => ['desk' => ['price' => 200]]], $array);
    }

    public function testSort()
    {
        $array = [
            ['name' => 'Desk'],
            ['name' => 'Chair'],
        ];
        $array = array_values(Arr::sort($array, function ($value) {
            return $value['name'];
        }));
        $expected = [
            ['name' => 'Chair'],
            ['name' => 'Desk'],
        ];
        $this->assertSame($expected, $array);
    }

    public function testSortRecursive()
    {
        $array = [
            'users' => [
                [
                    // should sort associative arrays by keys
                    'name' => 'joe',
                    'mail' => 'joe@example.com',
                    // should sort deeply nested arrays
                    'numbers' => [2, 1, 0],
                ],
                [
                    'name' => 'jane',
                    'age' => 25,
                ],
            ],
            'repositories' => [
                // should use weird `sort()` behavior on arrays of arrays
                ['id' => 1],
                ['id' => 0],
            ],
            // should sort non-associative arrays by value
            20 => [2, 1, 0],
            30 => [
                // should sort non-incrementing numerical keys by keys
                2 => 'a',
                1 => 'b',
                0 => 'c',
            ],
        ];
        $expect = [
            20 => [0, 1, 2],
            30 => [
                0 => 'c',
                1 => 'b',
                2 => 'a',
            ],
            'repositories' => [
                ['id' => 0],
                ['id' => 1],
            ],
            'users' => [
                [
                    'age' => 25,
                    'name' => 'jane',
                ],
                [
                    'mail' => 'joe@example.com',
                    'name' => 'joe',
                    'numbers' => [0, 1, 2],
                ],
            ],
        ];
        $this->assertSame($expect, Arr::sortRecursive($array));
    }

    public function testWhere()
    {
        $array = [100, '200', 300, '400', 500];
        $array = Arr::where($array, function ($key, $value) {
            return is_string($value);
        });
        $this->assertSame([1 => 200, 3 => 400], $array);
    }

    public function testForget()
    {
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::forget($array, null);
        $this->assertSame(['products' => ['desk' => ['price' => 100]]], $array);
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::forget($array, []);
        $this->assertSame(['products' => ['desk' => ['price' => 100]]], $array);
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::forget($array, 'products.desk');
        $this->assertSame(['products' => []], $array);
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::forget($array, 'products.desk.price');
        $this->assertSame(['products' => ['desk' => []]], $array);
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::forget($array, 'products.final.price');
        $this->assertSame(['products' => ['desk' => ['price' => 100]]], $array);
        $array = ['shop' => ['cart' => [150 => 0]]];
        Arr::forget($array, 'shop.final.cart');
        $this->assertSame(['shop' => ['cart' => [150 => 0]]], $array);
        $array = ['products' => ['desk' => ['price' => ['original' => 50, 'taxes' => 60]]]];
        Arr::forget($array, 'products.desk.price.taxes');
        $this->assertSame(['products' => ['desk' => ['price' => ['original' => 50]]]], $array);
        $array = ['products' => ['desk' => ['price' => ['original' => 50, 'taxes' => 60]]]];
        Arr::forget($array, 'products.desk.final.taxes');
        $this->assertSame(['products' => ['desk' => ['price' => ['original' => 50, 'taxes' => 60]]]], $array);
    }
}
