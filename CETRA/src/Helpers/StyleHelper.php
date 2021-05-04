<?php 

namespace App\Helpers;

class StyleHelper 
{
    public static function randomColor() : string
    {
        $color = '#';
        $letters = [10 => 'A', 11=> 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F'];
        for ($i = 0; $i < 6; $i++) {
            $number = (int)random_int(0, 15);
            $color .= $number >= 10 ? $letters[$number] : $number;
        }
        return $color;
    }
}

?>