<?php

$router = $di->getRouter();

// Define your routes here
// $router->add(
//   '/api/:controller/:action/:params',
//   [
//     'controller'=>1,
//     'action'=>2,
//     'params'=>3
//   ]
//   );

$router->handle();
