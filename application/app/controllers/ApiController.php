<?php

use Phalcon\Http\Response;
use Phalcon\Http\Client\Request;
use Phalcon\Queue\Beanstalk;

class ApiController extends ControllerBase
{
    var $response;
    public function initialize()
    {
        $this->view->disable();
        $this->response = new Response();
    }

    public function indexAction()
    {
        $this->response->setStatusCode(405);
        $this->response->setJsonContent(
            [
                'code'=>$this->response->getStatusCode()
            ]
        );

                return $this->response;
    }

    public function addJobAction($id = 'curl')
    {

        $jobId = $this->queue->put([$id=>5005]);

        return $this->response->setJsonContent(
            [
                'status'=>true,
                'data'=>[
                    'message'=>'Queue 등록완료. job id :'.$jobId
                ]
            ]
        );
    }

    public function queueStatusAction()
    {
        $status = $this->queue->stats();
        return $this->response->setJsonContent(
            [
                'status' => true,
                'data'=>$status
            ]
        );
    }

    public function queueDeleteAction()
    {
        

        while ($this->queue->peekReady()!==false) {
            $job = $this->queue->reserve();
            $this->logger->log(print_r($job, true));
            $job->delete();
        }

        return $this->response->setJsonContent(
            [
                'status' => true,
                'data'=>[
                    'All job deleted jobs'
                ]
            ]
        );
    }
}
