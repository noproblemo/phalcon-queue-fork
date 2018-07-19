#!/usr/bin/env php
<?php
$configFile = dirname(__DIR__).'/config/config.php';
if(is_readable($configFile)) {
  $config = include $configFile;
}

use Phalcon\Loader;
$loader = new Loader();
$loader->registerNamespaces([
  'Phalcon' => $config->application->libraryDir."incubator/Library/Phalcon"
])->register();

// require_once $config->application->libraryDir."incubator/Library/Phalcon/Queue/Beanstalk/Extended.php";
use Phalcon\Queue\Beanstalk\Extended as BeanstalkExtended;
use Phalcon\Queue\Beanstalk\Job;



$host = '169.254.194.218';

$beanstalk = new BeanstalkExtended([
  'host'  => $host
]);

$beanstalk->addWorker($host.'testJob', function(Job $job){
  $jobId = $job->getBody();
  echo print('job id :'.$jobId);
  exit(0);
});

$beanstalk->doWork();
