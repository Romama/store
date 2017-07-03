<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/30
 * Time: 16:59
 */
class LocalArticleController extends ControllerBase
{
    public function getArticleInfoAction()
    {
        $this->view->disable();
        $response = $this->response;
        if($this->request->isPost()){
            $articleId = $this->request->getPost("articleId");
            $articleLogic = new LocalArticleLogic();
            $article = $articleLogic->searchArticleById($this->errorCode,$this->errorMessage,$articleId);
            $this->returnDataRegularization($article,$response);
        } else {
            $this->askPostSend($response);
        }
    }
}