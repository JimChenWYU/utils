<?php

/*
 * This file is part of the jimchen/utils.
 *
 * (c) JimChen <18219111672@163.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace JimChen\Utils\Tests;

use PHPUnit\Framework\TestCase;
use function JimChen\Utils\data_get;
use function JimChen\Utils\value;

class HelpersTest extends TestCase
{
    public function testValue()
    {
        $this->assertSame('foo', value('foo'));

        $this->assertSame('bar', value(function () {
            return 'bar';
        }));
    }

    public function testDataGet()
    {
        $array = [
            'foo' => 'bar',
            'bar' => [
                'foo' => 'foobar',
            ],
        ];

        $this->assertSame('bar', data_get($array, 'foo'));
        $this->assertSame('foobar', data_get($array, 'bar.foo'));
        $this->assertSame('Hello', data_get($array, 'foobar', 'Hello'));
    }
}
