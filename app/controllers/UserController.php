<?php
/**
 * Created by PhpStorm.
 * User: WeiCuicui
 * Date: 2017/4/21
 * Time: 18:57
 * 连接访问mysql数据库
 */
class UserController extends ControllerBase
{
    /**
     * 加载Controller后，首先执行initialize初始化方法
     */
    public function initialize()
    {
        echo "UserController Starts!";
    }

    /**
     * initialize初始化后，在没有明确说明调用哪个action的情况下，默认调用indexAction
     */
    public function indexAction()
    {
        echo "Welcome to indexAction!";
    }
    /**
     * 登录
     */
    public function loginAction()
    {
        $this->view->disable();
        $response = $this->response; //注意，response是属性值，不是方法
        if($this->request->isPost()) {
            $name = "";
            $password = "";
            $params = $this->request->getPost();
            if(!empty($params["name"])){
                $name = $params["name"];
            }
            if(!empty($params["password"])){
                $password = $params["password"];
            }
            $userLogic = new UserLogic();
            $data = $userLogic->getUserByNameAndPwd($this->errorCode,$this->errorMessage,$name,$password);
            $this->returnDataRegularization($data,$response);
        }else {
            $this->askPostSend($response);
        }
    }
}