<?php

namespace Core;

/**
 * Description of successmessage
 * @date 12 sep. 2021
 * @time 4:50:43
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
class Success
{
    const SUCCESS_MENU_CREAR = "U2UgZ3VhcmRhcsOzbiBsb3MgZGF0b3MgZXhpdG9zYW1lbnRlLg==";
    const SUCCESS_MENU_ACTUALIZAR = "U2UgYWN0dWFsaXphcsOzbiBsb3MgZGF0b3MgZXhpdG9zYW1lbnRlLg==";
    const SUCCESS_MENU_ELIMINAR = "U2UgZWxpbWluYXLDs24gbG9zIGRhdG9zIGV4aXRvc2FtZW50ZS4=";

    public function __construct()
    {
        $this->successList = [
            Success::SUCCESS_MENU_CREAR => "Se guardarón los datos exitosamente.",
            Success::SUCCESS_MENU_ACTUALIZAR => "Se actualizarón los datos exitosamente.",
            Success::SUCCESS_MENU_ELIMINAR => "Se elimnarón los datos exitosamente.",
        ];
    }

    public function get($hash){
        return $this->successList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->successList)){
            return true;
        }else{
            return false;
        }
    }
}