<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 13:22
 */

namespace Mrstock\Middleware\Tests;

use PHPUnit\Framework\TestCase;

class RpcStartDealTest extends TestCase
{
    //检查应用端使用的中间件-鉴权ServiceToken
    public function testDeal()
    {
        $message['RPC_PATH'] = 'rpc.php';
        $message['callback'] = 'dsdsjkaskdnaskdnsdsadlnsadkas';
        //断言不为空
        $this->assertNotEmpty($message);
        //断言为数组
        $this->assertIsArray($message);
    }
}