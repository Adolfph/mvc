<?php

namespace Core;
/**
 * Description of view
 * @date 11 sep. 2021
 * @time 14:18:13
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
class View
{

    public function __construct()
    {

    }

    public function render($nombre, $data = [])
    {
        $this->d = $data;

        $this->handleMessages();
        
        require 'views/'.$nombre.'.php';
    }

    private function handleMessages()
    {
        if (isset($_GET['success']) && isset($_GET['error'])) {
            // no se muestra nada porque no puede haber un error y success al mismo tiempo
        } else if (isset($_GET['success'])) {

            $this->handleSuccess();
        } else if (isset($_GET['error'])) {
            $this->handleError();
        }
    }

    private function handleError()
    {
        if (isset($_GET['error'])) {
            $hash   = $_GET['error'];
            $errors = new \Core\Error();

            if ($errors->existsKey($hash)) {
                $this->d['error'] = $errors->get($hash);
            } else {
                $this->d['error'] = NULL;
            }
        }
    }

    private function handleSuccess()
    {
        if (isset($_GET['success'])) {
            $hash    = $_GET['success'];
            $success = new Success();

            if ($success->existsKey($hash)) {
                $this->d['success'] = $success->get($hash);
            } else {
                $this->d['success'] = NULL;
            }
        }
    }

    public function showMessages()
    {
        $this->showError();
        $this->showSuccess();
    }

    public function showError()
    {
        if (key_exists('error', $this->d)) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$this->d['error'].'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }

    public function showSuccess()
    {
        if (key_exists('success', $this->d)) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$this->d['success'].'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }
}
