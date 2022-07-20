<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 11:12
 */

namespace Mrstock\Middleware\Service;


use PHPUnit\Framework\TestCase;

class MqcontrolTest extends TestCase
{
    public function testHandle()
    {
        $request["serviceversion"] = 'v2';

        //断言不为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);
        //断言值
        $this->assertEquals($request['serviceversion'], 'v2');
    }
}