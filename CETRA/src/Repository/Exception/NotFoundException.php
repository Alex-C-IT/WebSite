<?php 

namespace App\Repository\Exception;

use \Exception;

class NotFoundException extends Exception
{
    public function __construct(string $table, int $id = null)
    {
        if ($id !== null) {
            $this->message = "Aucun enregistrement ne correspond à l'ID #$id dans la table '$table'.";
        } else {
            $this->message = "Aucun enregistrement trouvé dans la table '$table'.";
        }    
    }
}

?>