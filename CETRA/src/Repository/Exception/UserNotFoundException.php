<?php 

namespace App\Repository\Exception;

use \Exception;

class UserNotFoundException extends Exception
{
    public function __construct(string $table, string $username = null)
    {
        if ($username !== null) {
            $this->message = "Aucun utilisateur ne correspond au nom #$username dans la table '$table'.";
        } else {
            $this->message = "Aucun enregistrement trouvé dans la table '$table'.";
        }    
    }
}

?>