<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/7/3
 * Time: 15:19
 */
class LogLogic
{
    // 查找指定用户的日志信息
    public function getLogLogic(&$errorCode,&$errorMessage,$user)
    {
        try{
            if(empty($user)){
                $errorCode = 201;
                $errorMessage = "用户信息不能为空";
                return "";
            }
            $log = LoginInfo::findFirst(array(
                "conditions" => array("user" => $user)
            ));
            if(empty($log)){
                $errorCode = 201;
                $errorMessage = "该用户不存在日志";
                return "";
            }
            return $log;
        }catch (Exception $exception){
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
        }
    }

}