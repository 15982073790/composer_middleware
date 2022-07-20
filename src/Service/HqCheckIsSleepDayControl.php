<?php

namespace Mrstock\Middleware\Service;

use Mrstock\Mjc\Http\Request;
use Mrstock\Helper\Output;
use Mrstock\Helper\Config;

/**
 * 行情相关中间件-用于今日必须是交易日才运行的脚本场景(接口版本或者asyn实用)
 */
class HqCheckIsSleepDayControl
{

    private $request;

    public function handle(Request $request, \Closure $next)
    {

        try {
            if ($this->isinrest() == 0) {
                return Output::response("不在交易日", -1);
            }
        } catch (\Exception $e) {
            return Output::response($e->getMessage(), $e->getCode());
        }

        return $next($request);
    }

    /**
     * 判断今日是否是交易日
     * @author wangsongqing
     */
    public function isinrest($paramTime = 0)
    {
        $time = $paramTime ? $paramTime : time();
        $week = date('w', $time);
        $date = date('Y-m-d', $time);
        $vendor_sleepday = Config::get('vendor_sleepday');

        if (empty($vendor_sleepday)) {
            throw new \Exception('vendor_sleepday不正确', -1);
        }
        $vendor_sleepday = explode(',', $vendor_sleepday);

        if ((($week == 6 || $week == 0) || in_array($date, $vendor_sleepday))) {
            return 0; //不是交易日
        }
        return 1; //是交易日
    }
}