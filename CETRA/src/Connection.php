<?php 
namespace App;

use \PDO;
use PDOException;

class Connection {

    public static function getPDO() : PDO
    {
        $pdo =  new PDO('mysql:dbname=tutoblog;host=127.0.0.1', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        if ($pdo === null) {
            throw new PDOException();
        }

        return $pdo;
    }
}

?>