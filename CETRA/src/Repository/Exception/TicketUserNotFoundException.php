<?php 

namespace App\Repository\Exception;

use \Exception;

class TicketUserNotFoundException extends Exception
{
    public function __construct(string $table, int $id = null)
    {
        if ($id !== null) {
            $this->message = "Aucun ticket ne correspond à l'ID utilisateur #$id dans la table '$table'.";
        } else {
            $this->message = "Aucun enregistrement trouvé dans la table '$table'.";
        }    
    }
}

?>