<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/6/2
 * Time: 10:54
 * 时间线
 */
use Phalcon\Mvc\Model;
use Phalcon\Annotations\Adapter\Xcache;
$application->post('/time/line',function () use ($application){
    $articleCol = new Article();
    $articles = $articleCol->find(
        array(
            "name" => "shuji",
        ),
        array("_id","name","desc")
    );
    foreach ($articles as $article){
        echo json_decode($article);
    }
});