<?php 

namespace App\Helpers;

class TextHelper {

    public static function excerpt(string $text, int $limit = 60) : string 
    {
        if (mb_strlen($text) <= $limit)
           return  $text;

        $lastSpace = mb_strpos($text, ' ', $limit);
        return substr($text, 0, $lastSpace) . '...';  
    }

    public static function noScript(string $text) : string 
    {
        $seach = ['<script', '< script', '</script', '< /script', '< / script'];
        $replaceStart = '< noscript';
        $replaceEnd = '< /noscript';
        
        return str_replace($seach, $replaceEnd, $text);

    }
}
?>