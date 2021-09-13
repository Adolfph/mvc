<?php

namespace Core;
/**
 * Description of App
 * @date 11 sep. 2021
 * @time 13:32:06
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */

use Controllers\Errores;

class App
{

    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        // cuando se ingresa sin definir controlador
        if (empty($url[0])) {
            $controller = new \Controllers\Menu;
            $controller->loadModel('menu');
            $controller->render();
            return false;
        }
        $archivoController = 'controllers/'.$url[0].'.php';

        if (file_exists($archivoController)) {
            $namespace = "\\Controllers\\".$url[0];
            // inicializar controlador
            $controller = new $namespace;
            $controller->loadModel($url[0]);

            // si hay un método que se requiere cargar
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    if (isset($url[2])) {
                        //el método tiene parámetros
                        //sacamos e # de parametros
                        $nparam = sizeof($url) - 2;
                        //crear un arreglo con los parametros
                        $params = [];
                        //iterar
                        for ($i = 0; $i < $nparam; $i++) {
                            array_push($params, $url[$i + 2]);
                        }
                        //pasarlos al metodo
                        $controller->{$url[1]}($params);
                    } else {
                        $controller->{$url[1]}();
                    }
                } else {
                    $controller = new Errores();
                }
            } else {
                $controller->render();
            }
        } else {
            $controller = new \Controllers\Errores();
        }
    }
}
