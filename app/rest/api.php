<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/2
 * Time: 10:54
 * 时间线
 */
use Phalcon\Mvc\Model;
use Phalcon\Annotations\Adapter\Xcache;
$application->post('/nlp/getItemById',function () use ($application)
{
    $response = new ResponseUTF8();
    $errorCode = 200;
    $errorMessage = "Success";
    $data = "";
    try{
        $jsonObj = $application->request->getPost();
        if(empty($jsonObj['id'])){
            $errorCode = 201;
            $errorMessage = "id cannot be empty";
            $response->setJsonContent(array(
                "error_code" => $errorCode,
                "error_message" => $errorMessage,
                "data" => ""
            ));
            return $response;
        } else {
            $id = $jsonObj['id'];
            $data = WebdevNlp::findFirst(array(
                "conditions" => array("_id" => new MongoId($id))
            ));
        }
    }catch (Exception $exception){
        $errorCode = $exception->getCode();
        $errorMessage = $exception->getMessage();
    }
    $result = array(
        "error_code" => $errorCode,
        "error_message" => $errorMessage,
        "data" => $data
    );
    $response->setJsonContent($result);
    return $response;
});