<?php

namespace Utils\Crawler;

use Phalcon\Queue\Beanstalk;
use Phalcon\Http\Client\Request;
use Phalcon\Http\Response;
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;

class Manager extends Injectable
{
    public function initialize()
    {
        pcntl_signal(SIGCHLD, SIG_IGN);
    }

    public function start($cnt)
    {
        $pid = pcntl_fork();
        if ($pid == 0) {
            $this->queue->connect();
            if (($job = $this->queue->reserve()) !== false) {
                $jobId = $job->getId();
                $this->logger->log("get reserve job from queue");

                $this->logger->log('job id : '.$jobId);
                
                $dump = file_get_contents('https://reqres.in/api/users/'.$cnt);
                $this->logger->log(print_r($dump, true));

                $job->delete();
                $this->logger->log('job :'.$jobId.' deleted ');

                exit;
            }
        }
    }
}
