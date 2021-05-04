<?php 

function e($text, int $quote_style = null, string $charset = null, bool $double_encode = null) : ?string 
{
    return htmlentities($text, $quote_style, $charset, $double_encode);
}

?>
