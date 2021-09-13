<?php

namespace Core;

/**
 * Description of controller
 * @date 11 sep. 2021
 * @time 14:13:32
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
use Core\View;

class Controller
{

    public function __construct()
    {
        $this->view = new View();
    }

    public function loadModel($model)
    {
        $url = 'models/'.$model.'model.php';

        if (file_exists($url)) {
            $modelName   = "\\Models\\".$model.'Model';
            $this->model = new $modelName();
        }
    }

    public function existPOST($params)
    {
        foreach ($params as $param) {
            if (!isset($_POST[$param])) {
                error_log("ExistPOST: No existe el parametro $param");
                return false;
            }
        }
        return true;
    }

    public function existGET($params)
    {
        foreach ($params as $param) {
            if (!isset($_GET[$param])) {
                return false;
            }
        }
        return true;
    }

    public function getGet($name)
    {
        return $_GET[$name];
    }

    public function getPost($name)
    {
        return $_POST[$name];
    }

    public function redirect($route, $mensajes = [])
    {
        $data   = [];
        $params = '';

        foreach ($mensajes as $key => $value) {
            array_push($data, $key.'='.$value);
        }
        $params = join('&', $data);

        if ($params != '') {
            $params = '?'.$params;
        }
        header('location: '.constant('URL').$route.$params);
    }
}
