<?php 

namespace App\Repository\Exception;

use \Exception;

class NotPropertyFoundException extends Exception
{
    public function __construct(string $table, string $class)
    {
        $this->message = "La classe ". $class ." n'a pas de propriété '". $table ."'";
    }
}

?>