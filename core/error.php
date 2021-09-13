<?php

namespace Core;

/**
 * Description of ErrorMessages
 * @date 12 sep. 2021
 * @time 4:50:00
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
class Error
{
    const ERROR_MENU_CREAR = "Tm8gc2UgcHVkaWVyb24gZ3VhcmRhciBsb3MgZGF0b3Mu";
    const ERROR_MENU_ACTUALIZAR = "Tm8gc2UgaGEgcG9kaWRvIGFjdHVhbGl6YXIgZWwgcmVnaXN0cm8u";
    const ERROR_MENU_ELIMINAR = "Tm8gc2UgaGEgcG9kaWRvIGVsaW1pbmFyIGVsIHJlZ2lzdHJvLg==";
    const ERROR_MENU_DATOS_FALTANTES = "Tm8gc8OpIGVuY29udHJhcsOzbiBsb3MgZGF0b3MgbmVjZXNhcmlvcyBwYXJhIHJlYWxpemFyIGxhIGFjY2nDs24u";

    public function __construct()
    {
        $this->successList = [
            Error::ERROR_MENU_CREAR => "No se pudieron guardar los datos.",
            Error::ERROR_MENU_ACTUALIZAR => "No se ha podido actualizar el registro.",
            Error::ERROR_MENU_ELIMINAR => "No se ha podido eliminar el registro.",
            Error::ERROR_MENU_DATOS_FALTANTES => "No sé encontrarón los datos necesarios para realizar la acción.",
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