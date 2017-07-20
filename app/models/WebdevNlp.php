<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/7/20
 * Time: 11:23
 */

// webdev mongodb->nlpText->test_text
class WebdevNlp extends Collection
{
    public function initialize()
    {
        $this->setConnectionService("mongo_webdev");
    }
    public function getSource()
    {
        return "test_text";
    }
}