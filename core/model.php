<?php

namespace Core;

/**
 * Description of model
 * @date 11 sep. 2021
 * @time 14:12:01
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
class Model
{
    private $db;
    
    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function query($query)
    {
        return $this->db->connect()->query($query);
    }

    public function prepare($query)
    {
        return $this->db->connect()->prepare($query);
    }
}
