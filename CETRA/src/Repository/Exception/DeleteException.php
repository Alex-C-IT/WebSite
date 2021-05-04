<?php 

namespace App\Repository\Exception;

use \Exception;

class DeleteException extends Exception
{
    public function __construct(string $table, int $id)
    {
        $this->message = "Une erreur est survenue lors de la tentative de suppression de l'enregistrement #$id de la table '$table'";
    }
}

?>