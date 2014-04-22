<?php

define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'diditmed_LeagueTracker');
define('DB_USER', 'diditmed_league');
define('DB_PASS', '$.league@4321');

$router->add('/', 'home@index');