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

class HelpersTest extends TestCase
{
    public function testValue()
    {
        $this->assertSame('foo', \JimChen\Utils\value('foo'));

        $this->assertSame('bar', \JimChen\Utils\value(function () {
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

        $this->assertSame('bar', \JimChen\Utils\data_get($array, 'foo'));
        $this->assertSame('foobar', \JimChen\Utils\data_get($array, 'bar.foo'));
        $this->assertSame('Hello', \JimChen\Utils\data_get($array, 'foobar', 'Hello'));
    }
}
