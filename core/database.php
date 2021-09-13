<?php

namespace Core;

/**
 * Description of DataBase
 * @date 11 sep. 2021
 * @time 14:05:42
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
use PDO;
class DataBase
{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct()
    {
        $this->host     = constant('HOST');
        $this->db       = constant('DB');
        $this->user     = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset  = constant('CHARSET');
    }

    public function connect()
    {
        try {
            $connection = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
            $options    = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            error_log('Error connection: '.$e->getMessage());
        }
    }
}
