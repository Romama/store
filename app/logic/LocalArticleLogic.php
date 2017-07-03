<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/30
 * Time: 17:40
 */
class LocalArticleLogic
{
    // 根据articleId查询article信息
    public function searchArticleById(&$errorCode,&$errorMessage,$articleId)
    {
        try{
            if(empty($articleId)){
                $errorCode = 201;
                $errorMessage = "词条id不能为空";
                return "";
            }
            $article = LocalArticle::findFirst(array(
                "conditions" => array("_id" => new MongoId($articleId))
            ));
            if(empty($article)){
                $errorCode = 201;
                $errorMessage = "词条不存在";
                return "";
            }
            return $article;
        }catch (Exception $exception){
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
        }
    }
}