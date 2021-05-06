<?php

use App\Auth;
use App\Connection;
use App\Repository\TicketRepository;

if(!Auth::checkUserConnected())
    header('Location: '. $router->url('app_login'));

$title = "Suppression d'un ticket";

$pdo = Connection::getPDO();

$success = (new TicketRepository($pdo))->delete($params['id']);

if($success) {
    header('Location: ' . $router->url('espaceperso_ticket_index').'?id='.$params['id'].'&delete=1');
} else {
    header('Location: ' . $router->url('espaceperso_ticket_index').'?id='.$params['id'].'&delete=0');
}
