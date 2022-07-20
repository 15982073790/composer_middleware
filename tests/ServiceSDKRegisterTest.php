<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 13:41
 */

namespace Mrstock\Middleware\Tests;


use PHPUnit\Framework\TestCase;

class ServiceSDKRegisterTest extends TestCase
{
    public function testHandle()
    {
        $request['appcode'] = '5e746cf3a2095l855swnxafe';

        //断言不能为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);
        //断言值
        $this->assertEquals($request['appcode'], '5e746cf3a2095l855swnxafe');
    }
}