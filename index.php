<?php

/**
 *
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 * @date 11 sep. 2021
 * @time 12:36:56
 */

date_default_timezone_set('America/Mexico_City');

error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

ini_set('ignore_repeated_errors', true);

ini_set('display_errors', true);

ini_set('log_errors', true);

ini_set("error_log", "./menu-error.log");

include_once 'autoload.php';
require_once 'config/config.php';

use Core\App;
$app = new App();
