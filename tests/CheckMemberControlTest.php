<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 10:08
 */

namespace Mrstock\Middleware\Tests;


use PHPUnit\Framework\TestCase;

class CheckMemberControlTest extends TestCase
{
    public function testHandle()
    {
        $request['authMemberId'] = 11119;

        //断言不能为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);
        //断言值为11119
        $this->assertEquals($request['authMemberId'], 11119);
    }
}