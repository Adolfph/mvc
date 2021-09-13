<?php

/**
 *
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 * @date 11 sep. 2021
 * @time 14:16:25
 */
function showError($message)
{
    echo "<span class='error'>$message</span>";
}

function showInfo($message)
{
    echo "<span class='info'>$message</span>";
}

function showSuccess($message)
{
    echo "<span class='success'>$message</span>";
}
