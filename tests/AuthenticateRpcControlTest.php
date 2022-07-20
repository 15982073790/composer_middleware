<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 9:36
 */

namespace Mrstock\Middleware\Tests;


use PHPUnit\Framework\TestCase;

class AuthenticateRpcControlTest extends TestCase
{
    //检查restfulapi验证基类
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

    //检查获取url
    public function testGetUrl()
    {
        $request['server']['SERVER_PORT'] = 443;
        $request['server']['PHP_SELF'] = 'sdedasdasdsadsad';
        $request['server']['PATH_INFO'] = 'djfjdfisdfinmfnj1151145554';
        $request['server']['REQUEST_URI'] = 'jdfnjdsnfdfjkd7282312jdscxz';

        //断言不能为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);
    }
}