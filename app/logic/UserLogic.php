<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/30
 * Time: 17:47
 */
class UserLogic
{
    // 根据输入的username、userpwd，查询用户信息。mysql数据库表
    public function getUserByNameAndPwd(&$errorCode,&$errorMessage,$username,$userpwd)
    {
        try{
            if(empty($username)) {
                $errorCode = 201;
                $errorMessage = "user name cannot be empty";
                return "";
            }
            if(empty($userpwd)) {
                $errorCode = 201;
                $errorMessage = "user password cannot be empty";
                return "";
            }
            $conditions = 'username = :username: and userpwd = :userpwd:';
            $parameters = [
                'username' => $username,
                'userpwd' => $userpwd,
            ];

            /**
             * findFirst()返回的是一个User对象，但是，find()返回的是多个User对象的集合
             * 若待查记录确定只有一个，使用findFirst()；否则，使用find()
             */
            $user = User::findFirst(
                [
                    $conditions,
                    'bind' => $parameters,
                ]);

            if(empty($user)) {
                $errorCode = 201;
                $errorMessage = "user does not exist";
                return "";
            } else if(strcmp($userpwd,$user->userpwd) === 0) {
                $data = $user;
                return $data;
            } else {
                $errorCode = 201;
                $errorMessage = "the password is not correct";
                return "";
            }
        }catch (Exception $exception){
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
        }
    }
}