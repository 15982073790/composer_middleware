<?php

namespace Mrstock\Middleware\Service;

use Mrstock\Helper\Output;
use Mrstock\Mjc\Http\Request;
use Mrstock\Helper\Config;
use Mrstock\Servicesdk\PhpAmqpLibSdk\PhpAmqpLibFactory;

/**
 * 代理应用端使用的中间件-帮客户端中转服务
 */
class MqControl
{

    private $request;

    public function handle(Request $request, \Closure $next)
    {
        if (empty($request["serviceversion"]) || $request["serviceversion"] == "v1") {
            $mqstr = 'hooks.mq';
        } else {
            $mqstr = 'hooks.' . $request["serviceversion"] . '.mq';
        }
        //$mqstr=empty($request["serviceversion"])?'hooks.mq':'hooks.'.$request["serviceversion"].'.mq';
        if ($request["c"] == "inihook") {
            $mq = Config::get($mqstr);
            if (empty($mq)) {
                $mq = [];
            }
            return Output::response($mq, 1);
        }

        if (empty($request["site"]) || empty($request["c"]) || empty($request["a"])) {
            return Output::response("empty site c a", -1);
        }

        $target_site = $request["c"];
        $target_event = $request["a"];
        $site = $request["site"];

        $hook_name = $target_site . '_' . $target_event;
        if (!empty($request["parallelismFlag"])) {
            $hook_name = $target_site . '_' . $target_event . "@" . $request["parallelismFlag"];
            $site = $site . "@" . $request["parallelismFlag"];
        }
        $mq = Config::get($mqstr);
        $mq_key = array_keys($mq);


        if (empty($mq_key) || !in_array($hook_name, $mq_key)) {
            return Output::response("no hook ini", -1);
        }


        $hook_class = $mq[$hook_name];
        PhpAmqpLibFactory::listen($target_site, $target_event, $hook_class, $site);

        return true;
    }


}
