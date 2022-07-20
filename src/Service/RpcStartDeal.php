<?php

namespace Mrstock\Middleware\Service;

/**
 * 应用端使用的中间件-鉴权ServiceToken
 */
class RpcStartDeal
{


    public static function deal($message)
    {

        static $app;

        if (!include_once($message["RPC_PATH"]))
            exit('rpc.php isn\'t exists!');


        $_REQUEST = $_POST = $_GET = $message;


        try {
            if (!$app) {
                $app = new \Mrstock\Mjc\App();
            }
            // \Mrstock\Helper\Config::clear();
            // \Mrstock\Helper\Config::register();
            $response = $app->run();
            $data = $response->getContent();
        } catch (\Exception $ex) {
            if (\Mrstock\Orm\Model::$open_begintransaction == true) {
                (new \Mrstock\Orm\Model())->closeTransaction();
            }
            $error['message'] = $ex->getMessage();
            $code = $ex->getcode();
            $status = 200;
            $response = \Mrstock\Helper\Output::response($error['message'], $code, $status);
            $data = $response->getContent();
        }

        if (isset($message['callback']) && $message['callback']) {

            $data = str_replace($message['callback'], "", $data);
            $data = str_replace("(", "", $data);
            $data = str_replace(");", "", $data);
        }
        $result = json_decode($data);
        if (empty($result)) {
            \Mrstock\Mjc\Facade\Log::write(print_r($_REQUEST, true) . " rs:" . $data, RPCERR);
        }
        return $result;


    }


}

