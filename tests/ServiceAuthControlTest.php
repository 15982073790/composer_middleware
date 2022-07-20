<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 9:09
 */

namespace Mrstock\Middleware\Tests;

use PHPUnit\Framework\TestCase;

class ServiceAuthControlTest extends TestCase
{
    public function testHandle()
    {
        $request['appcode'] = '5e746cf3a2095l855swnxafe';
        $request['c'] = 'index';
        $request['a'] = 'index';
        $request['v'] = 'app';

        //断言不能为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);

    }
}