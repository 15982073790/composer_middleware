<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/12
 * Time: 15:58
 */

namespace Mrstock\Middleware\Tests;


use Mrstock\Middleware\Member\Model\AuthUserTokenModel;
use PHPUnit\Framework\TestCase;

class AuthUserTokenModelTest extends TestCase
{
    //检查查询
    public function testGetUserTokenInfo()
    {
        //$AuthUserTokenModel = new AuthUserTokenModel();
        $condition['member_id'] = 110;
        $condition['route_mark'] = 'app';

        //断言不能为空
        $this->assertNotEmpty($condition);
        //断言为数组
        $this->assertIsArray($condition);
    }

    //检查获取
    public function testGetUserTokenInfoByID()
    {
        $member_id = 1120;
        //断言不能为空
        $this->assertNotEmpty($member_id);
        //断言为数字
        $this->assertIsInt($member_id);

        $route_mark = 'app';
        //断言不能为空
        $this->assertNotEmpty($route_mark);
        //断言为字符串
        $this->assertIsString($route_mark);

        $key = 'sjdsajkdsakdsjdlskdsadlksadk=';
        //断言不能为空
        $this->assertNotEmpty($key);
        //断言为字符串
        $this->assertIsString($route_mark);

    }
}