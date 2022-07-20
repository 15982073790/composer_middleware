<?php

namespace Mrstock\Middleware\Service\Cxt;

use Mrstock\Helper\Config;
use Mrstock\Helper\HttpRequest;
use Mrstock\Mjc\Http\Request;
use Mrstock\Helper\Output;
use Mrstock\Mjc\Facade\Log;

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
        $this->request = $request;
        try {
            $this->checkAuthenticate();
        } catch (\Exception $e) {
            return Output::response($e->getMessage(), $e->getCode());
        }
        return $next($this->request);
    }


    private function checkAuthenticate()
    {
        //验证appcode
        if (empty($this->request->param["appcode"]) || !in_array($this->request->param["appcode"], array_keys(Config::get("appcode_hash")))) {
            throw new \Exception('appcode不正确', '-1002');
        }

        $site = $this->request->site;
        $v = $this->request->v;
        $c = $this->request->c;
        $a = $this->request->a;
        if (empty($site) || empty($c) || empty($a)) {
            throw new \Exception('接口不正确', '-1003');
        }

        if (strtolower($v) == "inneruse" && !in_array(strtolower($site), ['news', 'uploadfile'])) {
            if (empty($this->request->param["access_token"])) {
                throw new \Exception('access_token必须', '-1002');
            }
            $rpc_inneruse_secretkey = Config::get("rpc_inneruse_secretkey");
            $access_data = [
                'c' => $c,
                'a' => $a,
                'v' => $v,
                'site' => $site,
                'inneruse_secretkey' => $rpc_inneruse_secretkey,
                'serviceversion' => $this->request->serviceversion,
                'timestamp' => (string)$this->request->timestamp,
            ];
            rsort($access_data);
            $access_data_str = implode('-', $access_data);
            $access_token = md5($access_data_str);
            if ($this->request->param["access_token"] != $access_token) {
                Log::record('签名错误:' . var_export($_SERVER, true));
                throw new \Exception('签名错误', '-1002');
            }
            if ($this->request->param["timestamp"] + 60 < time()) {
                Log::record('access_token已过期:' . var_export($_SERVER, true));
                throw new \Exception('access_token已过期', '-1002');
            }
        }

        if (strtolower($v) == "company") {
            $data['check_c'] = $c;
            $data['check_a'] = $a;
            $data['check_v'] = $v;
            $data['check_site'] = $site;
            $data['admin_id'] = $this->request->admin_id;
            $data['key'] = $this->request->key;

            $data['site'] = 'gateway';
            $data['c'] = 'auth';
            $data['a'] = 'adminisauth';
            $data['v'] = 'inneruse';
            $data['inneruse_secretkey'] = Config::get("rpc_inneruse_secretkey");
            if (empty($data['inneruse_secretkey'])) {
                $data['inneruse_secretkey'] = c("rpc_inneruse_secretkey");
            }
            $url = "http://gateway.api.caixuetang.cn/index.php";
            $res = HttpRequest::query($url, $data, 1);
            if ($res["code"] != 1) {
                throw new \Exception($res["message"], $res["code"]);
            }

        } else if (substr(strtolower($v), 0, 4) == "user") {
            $member_id = $this->request->param["member_id"];
            $key = $this->request->param["key"];
            if (empty($member_id) || empty($key)) {
                throw new \Exception('用户账号登录参数错误', '-1007');
            }
            $url = "http://login.api.guxiansheng.cn/index.php?c=user_cxt&a=token_auth";
            $res = HttpRequest::query($url, ['member_id' => $member_id, 'key' => $key]);
            if ($res["code"] != 1) {
                if ($res["message"] == 'key已过期') {
                    throw new \Exception($res["message"], -2);
                } else {
                    throw new \Exception($res["message"], $res["code"]);
                }
            }
        }
    }
}
