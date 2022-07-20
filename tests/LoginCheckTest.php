<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/8
 * Time: 14:25
 */

namespace Mrstock\Middleware\Tests;

use PHPUnit\Framework\TestCase;

class LoginCheckTest extends TestCase
{
    public function testLoginCheck()
    {
        $arr['member_id'] = 123;
        //断言不为空
        $this->assertNotEmpty($arr);
        //端为数组
        $this->assertIsArray($arr);
    }
}