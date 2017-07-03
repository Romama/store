<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $errorMessage = "Success";
    protected $errorCode = 200;

    // 返回结果规则化
    protected function returnDataRegularization($data,$response)
    {
        $response->setHeader("content-type", "application/json;charset=UTF-8");
        $response->setJsonContent(array(
            'error_code'    => $this->errorCode,
            'error_message' => $this->errorMessage,
            'data'    => $data
        ));
        $response->send();
    }

    // 使用post方式进行http请求
    protected function askPostSend($response)
    {
        $response->setHeader("content-type", "application/json;charset=UTF-8");
        $response->setJsonContent(array(
            'error_code'    => 202,
            'error_message' => "请使用post方式进行http请求",
            'data'    => ""
        ));
        $response->send();
    }
}
