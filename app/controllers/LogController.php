<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/7/3
 * Time: 15:17
 */
// log 日志 controller
class LogController extends ControllerBase
{
     public function searchLogAction()
     {
         $this->view->disable();
         $response = $this->response;
         if($this->request->isPost()){
             $user = $this->request->getPost("user");
             $logLogic = new LogLogic();
             $log = $logLogic->getLogLogic($this->errorCode,$this->errorMessage,$user);
             $this->returnDataRegularization($log,$response);
         } else {
             $this->askPostSend($response);
         }
     }
}