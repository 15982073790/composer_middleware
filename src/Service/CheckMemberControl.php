<?php

namespace Mrstock\Middleware\Service;

use Mrstock\Mjc\Http\Request;
use Mrstock\Helper\Output;
use Mrstock\Servicesdk\JsonRpc\RpcClientFactory;
use Mrstock\Helper\Config;

/**
 * 应用端使用的中间件-鉴权ServiceToken
 */
class CheckMemberControl
{

    private $request;

    public function handle(Request $request, \Closure $next)
    {

        $this->request = $request;

        if (!$this->request->authMemberId) {

            return Output::response("没有登录", "-9999");
        }
        return $next($this->request);
    }


}