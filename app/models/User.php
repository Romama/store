<?php
/**
 * Created by PhpStorm.
 * User: WeiCuicui
 * Date: 2017/4/24
 * Time: 10:55
 */
use Phalcon\Mvc\Model;

// local mysql->test->User
class User extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $userpwd;

    /**
     * @return string
     * 返回该Model对应的数据库表名
     */
    public function getSource()
    {
        return "user";
    }
}