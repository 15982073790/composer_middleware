<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 13:35
 */

namespace Mrstock\Middleware\Tests;


use PHPUnit\Framework\TestCase;

class ServiceServiceAuthControlTest extends TestCase
{
    public function testHandle()
    {
        $request['param']["appcode"] = '5e746cf3a2095l855swnxafe';

        $request['param']['access_token'] = 'scdsdaDSasa1154845sasaSASAss';
        $request['param']['a'] = 'index';
        $request['param']['c'] = 'index';
        $request['param']['site'] = 'app';

        //断言不能为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);
    }

}