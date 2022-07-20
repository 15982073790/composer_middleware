<?php

namespace Mrstock\Middleware\Member\Facade;

use Mrstock\Mjc\Facade;
use Mrstock\Mjc\Container;
use Mrstock\Redis\RedisHelper;

class RedisFacade extends Facade
{

    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     *
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        $isExist = Container::getInstance()->exists("middleware_member_redis");
        if (!$isExist)
            Container::set('middleware_member_redis', new RedisHelper());

        return 'middleware_member_redis';
    }
}
