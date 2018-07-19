<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $headerCollection = $this->assets->collection('header');
        $headerCollection->addCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', false);

        $footerCollection = $this->assets->collection('footer');
        $footerCollection->addJs('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js', false);
        $footerCollection->addJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false);
    }
}
