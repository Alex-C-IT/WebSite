<?php

use App\Auth;

if(!Auth::checkUserConnected())
    header('Location: '. $router->url('app_login'));


$title = "Accueil espace personnel";
?>

<h1>Espace personnel</h1>

