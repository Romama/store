<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/30
 * Time: 18:11
 */
use Phalcon\Mvc\Collection;

// localhost mongodb->log->login_info
class LoginInfo extends Collection
{
    public function initialize()
    {
        $this->setConnectionService("mongo_log");
    }
    public function getSource()
    {
        return "login_info";
    }

}