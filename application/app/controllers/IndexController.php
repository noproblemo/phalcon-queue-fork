<?php
use Phalcon\Http\Client\Request;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        echo "test";
    }
}
