<?php

namespace App\HTML\Exceptions;

use Exception;

class TableEmptyException extends Exception
{
    public function __construct()
    {
        $this->message = "Le tableau de données ne peut pas être vide.";
    }
}

?>