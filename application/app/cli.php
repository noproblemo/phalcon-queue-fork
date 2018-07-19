<?php

use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;
use Phalcon\Queue\Beanstalk;

$di = new CliDi(); 

$loader = new Loader();

$configFile = __DIR__.'/config/config.php';

  if(is_readable($configFile)) {
    $config = include $configFile;
    $di->set('config', $config);

    $di->setShared('db', function () {
      $config = $this->getConfig();

      $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
      $params = [
          'host'     => $config->database->host,
          'username' => $config->database->username,
          'password' => $config->database->password,
          'dbname'   => $config->database->dbname,
          'charset'  => $config->database->charset
      ];

      if ($config->database->adapter == 'Postgresql') {
          unset($params['charset']);
      }

      $connection = new $class($params);

      return $connection;
  });

  $di->setShared('logger', function(){
    $logger = new StreamAdapter('php://stderr');

    return $logger;
});

  $di->set('queue', function(){
    $beanstalkIp = getenv('BEANSTALK_IP');
    $queue = new Beanstalk([
      'host'=>$beanstalkIp,
      'port'=>'11300',
    ]);

    return $queue;
  });

  }


  // echo "config :".$config->application->libraryDir.'utils/'.PHP_EOL;

$loader->registerDirs([
    __DIR__.'/tasks'
  ]);

  $loader->registerNamespaces([
    'Utils'=>$config->application->libraryDir.'utils',
    'Phalcon'=>$config->application->libraryDir.'incubator/Library/Phalcon/'
]);

  $loader->register();


  $console = new ConsoleApp();
  $console->setDi($di);

  $arguments = [];

  foreach ($argv as $k => $arg) {
    if($k === 1){
      $arguments['task'] = $arg;
    }elseif($k === 2){
      $arguments['action'] = $arg;
    }elseif ($k >= 3){
      $arguments['params'][] = $arg;
    }
  }

try {
  $console->handle($arguments);
}catch (\Phalcon\Exception $e) {
  fwrite(STDERR, $e->getMessage().PHP_EOL);
  exit(1);
}catch(\Throwable $throwable){
  fwrite(STDERR, $throwable->getMessage().PHP_EOL);
  exit(1);
} catch(\Exception $exception) {
  fwrite(STDERR, $exception->getMessage().PHP_EOL);
  exit(1);
}