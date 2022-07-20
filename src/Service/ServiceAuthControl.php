<?php

namespace Mrstock\Middleware\Service;

use Common\Logic\Manager\AdminLogic;
use Mrstock\Mjc\Facade\Log;
use Mrstock\Mjc\Http\Request;
use Mrstock\Helper\Output;
use Mrstock\Servicesdk\JsonRpc\RpcClientFactory;
use Mrstock\Helper\Config;
use Mrstock\Helper\HttpRequest;
use Common\Logic\UserLogic;

/**
 * 服务鉴权中间件
 */
class ServiceAuthControl
{

    private $request;

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed|\Mrstock\Helper\unknown
     */
    public function handle(Request $request, \Closure $next)
    {
        $this->checkAuthenticate($request);
        return $next($request);
    }

    /**
     * @throws \Exception
     * apicode与app_code验证
     */
    private function checkAuthenticate($request)
    {
        if (empty($request["appcode"]) || $request["appcode"] != Config::get("vendor_appcode")) {
            throw new \Exception('appcode不正确', '-1002');
        }
        $v = $request['v'];
        $c = $request['c'];
        $a = strtolower($request['a']);
        if ($v == "cli") {
            return;
        }
        if (empty($c) || empty($a)) {
            throw new \Exception('接口不正确', '-1003');
        }
        if (empty($v)) {
            $v = "app";
        }
        //用户鉴权
        if ($v == 'direct') {
            return;
        }
        //用户鉴权
        if ($v == 'app') {//除了c=user&a=login接口之外都验证token
            if ($c == 'user' && $a == 'login') {
                return;
            }
            $user_id = $request["user_id"];
            if (empty($user_id)) {
                throw new \Exception('user_id必填', '-1');
            }
            $token = $request["token"];
            $res = (new UserLogic())->verify_token_auth($user_id, $token);
            if ($res == false) {
                throw new \Exception('请重新登陆', '-1004');
            }
        }
        //管理员鉴权
        if ($v == 'manager') {
            if ($c == 'admin' && $a == 'login') {
                return;
            }
            $admin_id = $request["admin_id"];
            $token = $request["token"];
            $res = (new AdminLogic())->verify_token_auth($admin_id, $token);
            if ($res == false) {
                throw new \Exception('请重新登陆', '-1004');
            }
        }
    }
}
