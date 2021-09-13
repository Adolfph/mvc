<?php

namespace Controllers;
/**
 * Description of errores
 * @date 11 sep. 2021
 * @time 16:17:15
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
use Core\Controller;
class Errores extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->view->render('errores/index');
    }
}