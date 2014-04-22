<?php

require(SYS_CORE.SEP.'Router.php');

$router = new Router();

require(SYS_CORE.SEP.'paths.php');
require(BASE_PATH.SEP.'config'.SEP.'config.php');
require(SYS_CORE_LIBRARY_DIR.SEP.'loader.php');
require(SYS_CORE_LIBRARY_DIR.SEP.'object.php');
require(SYS_CORE_LIBRARY_DIR.SEP.'view.php');

$router->routeRequest();
