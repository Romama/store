<?php
class ResponseUTF8 extends Phalcon\Http\Response {
    function __construct(){
        parent::__construct();
        $this->setContentType('text/html', 'UTF-8');
        $this->setHeader('Cache-Control', 'public');
    }
}
