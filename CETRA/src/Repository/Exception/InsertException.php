<?php

namespace App\Repository\Exception;

use \Exception;

class InsertException extends Exception
{
    public function __construct(string $table)
    {
        $this->message = "Une erreur est survenue lors de la tentative d'enregistrement dans la table '$table'";
    }
}