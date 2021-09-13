<?php

namespace Controllers;

/**
 * Description of Home
 * @date 11 sep. 2021
 * @time 13:58:41
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
use Core\Controller;
use Models\MenuModel;
class Home extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $menus = new MenuModel();
        $this->view->render('home/index', ['ordered' => $menus->getOrderedMenus()]);
    }
}