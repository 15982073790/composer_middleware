<?php

namespace Mrstock\Middleware\Service;

use Mrstock\Mjc\Http\Request;
use Common\Logic\UserLogic;

/**
 * 设置在线时间中间件
 */
class UserOnlineControl
{

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed|\Mrstock\Helper\unknown
     */
    public function handle(Request $request, \Closure $next)
    {
        $this->setOnline($request);//设置最后在线时间
        return $next($request);
    }

    /**
     * @throws \Exception
     * 设置用户的最后在线时间
     */
    private function setOnline($request)
    {

        $user_id = $request["user_id"];
        if ($user_id) {
            (new UserLogic())->setLastOnlineTime($user_id);//设置最后登录时间
        }
    }
}
