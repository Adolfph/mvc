<?php

/**
 *
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 * @date 12 sep. 2021
 * @time 0:24:46
 */
function autoload($clase)
{
    $url = str_replace("\\", "/", strtolower($clase).".php");
    require_once($url);
}
spl_autoload_register('autoload');
