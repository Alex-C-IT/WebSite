<?php 

namespace App;

use App\Security\ForbiddenException;

class Auth 
{
    public static function checkUserConnected(): bool
    {
        // session active ?
        if(session_status() ===  PHP_SESSION_NONE) session_start();

        // Vérifie si la session existe
        if(!isset($_SESSION['auth'])) {
            return false;
            throw new ForbiddenException();
        }

        return true;
    }
}

?>