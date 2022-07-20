<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 13:48
 */

namespace Mrstock\Middleware\Tests;


use PHPUnit\Framework\TestCase;

class ServiceTokenControlTest extends TestCase
{
    public function testHandle()
    {
        $data['site'] = "base";
        $data['c'] = "Token";
        $data['a'] = "get";
        $data['appcode'] = '5e746cf3a2095l855swnxafe';
        $data['member_id'] = 1110;
        $data['key'] = 'dhfhdfdklDBSDJKNJKNJsjdsj15';

        //断言不能为空
        $this->assertNotEmpty($data);
        //断言为数组
        $this->assertIsArray($data);
    }
}