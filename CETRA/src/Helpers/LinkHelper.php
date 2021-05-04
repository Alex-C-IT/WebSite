<?php 

namespace App\Helpers;

class LinkHelper
{
    public static function isActive(array $_serv, string $url) : bool 
    {
        if($url === $_serv['REQUEST_URI'])
            return true;

        return false;
    }
}

?>