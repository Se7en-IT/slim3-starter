<?php

error_reporting(E_ALL | E_STRICT);
error_reporting(error_reporting() & ~E_NOTICE);

define('ROOT', dirname(__FILE__));
define('APPROOT', ROOT. "/app");
define('SLIM_MODE_LOCAL', 'local');
define('SLIM_MODE', SLIM_MODE_LOCAL);

$app = require_once ROOT . '/app/bootstrap.php';

$app->run();
