<?php

use App\Auth;
use App\Connection;
use App\Repository\TicketRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
}

$title = "Suppression d'un ticket";

$pdo = Connection::getPDO();

$success = (new TicketRepository($pdo))->delete($params['id']);

if($success) {
    header('Location: ' . $router->url('admin_ticket_index').'?id='.$params['id'].'&delete=1');
} else {
    header('Location: ' . $router->url('admin_ticket_index').'?id='.$params['id'].'&delete=0');
}
