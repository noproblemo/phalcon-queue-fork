<?php

use Phalcon\Cli\Task;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;
use Utils\Crawler\Manager;

define('MAXPROCESS', 10);

/**
 * cli task
 */
class ForkworkerTask extends Task
{

    private $manager;
    private $workerCnt = 1;

    public function initialize()
    {
        $this->manager = new Manager();
    }

    public function startAction()
    {

        while (true) {
            if ($this->queue->peekReady() !== false) {
                $this->manager->start($this->workerCnt++);
            }
        }
    }
}
