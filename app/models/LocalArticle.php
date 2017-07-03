<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/30
 * Time: 16:38
 */
use Phalcon\Mvc\Collection;

// localhost mongodb->cuicui->article
class LocalArticle extends Collection
{
    public function initialize()
    {
        $this->setConnectionService("mongo_test");
    }
    public function getSource()
    {
        return "article";
    }
}
