<?php

namespace Mrstock\Middleware\Service;

use Mrstock\Mjc\Http\Request;
use Mrstock\Helper\Output;
use Mrstock\Helper\Config;
use MrstockCloud\Client\MrstockCloud;

/**
 * 服务SDK注册中间件
 */
class ServiceSDKRegister
{

    private $request;

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed|\Mrstock\Helper\unknown
     */
    public function handle(Request $request, \Closure $next)
    {
        $this->request = $request;
        try {
            $appcode = $this->request->appcode;
            if (empty($appcode)) {
                return Output::response('appcode', -1);
            }
            $secretKey = Config::get("rpc_inneruse_secretkey");

            MrstockCloud::appcodeSecretKey($appcode, $secretKey);
        } catch (\Exception $e) {
            return Output::response($e->getMessage(), $e->getCode());
        }
        return $next($this->request);
    }
}