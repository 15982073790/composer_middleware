<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/12
 * Time: 15:59
 */

namespace Mrstock\Middleware\Tests;


use Mrstock\Middleware\Member\Facade\RedisFacade;
use PHPUnit\Framework\TestCase;

class RedisFacadeTest extends TestCase
{
    public function testRedisFacade()
    {
        $key = 'middleware_member_redis';

        //断言为字符串
        $this->assertIsString($key);
        //断言不能为空
        $this->assertNotEmpty($key);
    }
}