<?php
require ROOT . '/vendor/autoload.php';

date_default_timezone_set('Europe/Rome');

/*SETUP CONFIG*/
$container = new \Slim\Container([
	"config" => array_merge_recursive(
		require_once APPROOT . '/config/slim.php',
		require_once APPROOT . '/config/slim-' . SLIM_MODE . '.php'
	)
]);
/*SETUP DB*/
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->config[database]);
$capsule->bootEloquent();
$container["db"] =  function ($c) use ($capsule){
	return $capsule->getConnection();
};
/*SETUP SERVICE*/
$container["logger"] = function(){
	$logger = new \Monolog\Logger('logger');
	$logger->pushHandler(new \Monolog\Handler\RotatingFileHandler(APPROOT . '/logs/logger.log', 10, \Monolog\Logger::WARNING));
	return $logger;
};

$container["errorHandler"] = function ($c) {
	return function($request, $response, $ex) use ($c){
		$c->logger->addError($ex);
		return $response->withJson($ex->getMessage());
	};
};

/*START SLIM*/
$app = new \Slim\App($container);

foreach(glob(APPROOT . '/controllers/*.php') as $router) {
	include $router;
}

return $app;
