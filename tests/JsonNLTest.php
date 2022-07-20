<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 10:32
 */

namespace Mrstock\Middleware\Tests;


use Mrstock\Middleware\Service\JsonNL;
use PHPUnit\Framework\TestCase;

class JsonNLTest extends TestCase
{
    //检查 检查包的完整性
    public function testInput()
    {
        $JsonNL = new JsonNL();

        $buffer = "jhdsfhdfhhjhjhjbsasddsadadddddd\nddddddddddddddddddd9o\nfdskjxzcsshsdbsajdnsakjdbHAS";

        //断言为字符串
        $this->assertIsString($buffer);

        $res = $JsonNL::input($buffer);

        //断言为数字
        $this->assertIsInt($res);

        //断言值
        $this->assertEquals($res, 32);

    }

    //检查 打包，当向客户端发送数据的时候会自动调用
    public function testEncode()
    {
        $JsonNL = new JsonNL();

        $buffer ['app'] = "jhdsfhdfhhjhjhjbsasddsadadddddd";
        $buffer ['appcode'] = "5c6bb51a113c8szji5nb6cur";

        //断言为字符串
        $this->assertIsArray($buffer);

        $res = $JsonNL::encode($buffer);

        //断言不能为空
        $this->assertNotEmpty($res);

        //断言为字符串
        $this->assertIsString($res);

    }

    //检查解包，当接收到的数据字节数等于input返回的值（大于0的值）自动调用
    public function testDecode()
    {
        $JsonNL = new JsonNL();

        $buffer = '{"app":"jhdsfhdfhhjhjhjbsasddsadadddddd","appcode":"5c6bb51a113c8szji5nb6cur"}';

        //断言为字符串
        $this->assertIsString($buffer);

        $res = $JsonNL::decode($buffer);

        //断言不能为空
        $this->assertNotEmpty($res);

        //断言为字符串
        $this->assertIsArray($res);

        //断言值
        $this->assertEquals($res['app'], 'jhdsfhdfhhjhjhjbsasddsadadddddd');
        //断言值
        $this->assertEquals($res['appcode'], '5c6bb51a113c8szji5nb6cur');
    }
}