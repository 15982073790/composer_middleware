<?php
/**
 * Created by PhpStorm.
 * User: 李勇刚
 * Date: 2020/7/13
 * Time: 10:14
 */

namespace Mrstock\Middleware\Tests;


use Mrstock\Helper\Config;
use Mrstock\Middleware\Service\HqCheckIsSleepDayControl;
use PHPUnit\Framework\TestCase;

class HqCheckIsSleepDayControlTest extends TestCase
{
    //检查判断今日是否是交易日
    public function testIsInrest()
    {
        $HqCheckIsSleepDayControl = new HqCheckIsSleepDayControl();
        $paramTime = '1594517400';
        //$paramTime = '1594603800';
        $config['vendor_sleepday'] = '2020-01-01,2020-01-24,2020-01-25,2020-01-26,2020-01-27,2020-01-28,2020-01-29,2020-01-30,2020-01-31,2020-04-04,2020-04-05,2020-04-06,2020-05-01,2020-05-02,2020-05-03,2020-05-04,2020-05-05,2020-06-25,2020-06-26,2020-06-27,2020-10-01,2020-10-02,2020-10-03,2020-10-04';
        Config::set($config);
        $res = $HqCheckIsSleepDayControl->isinrest($paramTime);

        //断言为数字
        $this->assertIsInt($res);
        //断言值
        $this->assertContains($res, [0, 1]);
    }
}