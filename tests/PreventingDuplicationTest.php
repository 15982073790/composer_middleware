<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 11:23
 */

namespace Mrstock\Middleware\Tests;


use Mrstock\Helper\Config;
use Mrstock\Middleware\Service\PreventingDuplication;
use Mrstock\Mjc\App;
use Mrstock\Mjc\Container;
use PHPUnit\Framework\TestCase;

class PreventingDuplicationTest extends TestCase
{
    //断言 数据修改防止重复
    public function testHandle()
    {
        $request['param']['rpc_msg_time'] = time();
        $request['param']['rpc_msg_id'] = 12335511558681;
        $request['param']['callback'] = 1;

        //断言不为空
        $this->assertNotEmpty($request);
        //断言为数组
        $this->assertIsArray($request);
    }

    //断言 数据修改防止重复
    public function testIsDuplication()
    {
        $param['rpc_msg_time'] = time();
        $param['rpc_msg_id'] = 12335511558681;
        $param['callback'] = 1;
        $config['redis_config']['appcluster'] = array(
            'prefix' => '',
            'dynamicprefix' => ['site', 'appcode'],
            'type' => 'redis',
            'master' => array(array('host' => '192.168.10.231', 'port' => 6379, 'pconnect' => 0, 'db' => 0)),
            'slave' => array(array('host' => '192.168.10.231', 'port' => 6379, 'pconnect' => 0, 'db' => 0))
        );

        Config::set($config);
        Container::set('app', new App());
        //断言不为空
        $this->assertNotEmpty($param);
        //断言为数组
        $this->assertIsArray($param);

        $res = (new PreventingDuplication())->isDuplication($param);

        //断言不为空
        $this->assertNotEmpty($param);
        //断言为
        $this->assertIsInt($res);
        //断言值
        $this->assertContains($res, [0, 1]);

    }

}