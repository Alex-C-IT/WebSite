<?php


use App\Auth;
use App\Connection;
use App\Repository\PartnerRepository;
use App\Attachment\PartnerAttachment;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Suppression d'un partenaire";

$pdo = Connection::getPDO();
$partnerRepository = new PartnerRepository($pdo);
$partner = $partnerRepository->find($params['id']);
PartnerAttachment::detach($partner);
$success = $partnerRepository->delete($params['id']);

if($success) {
    header('Location: ' . $router->url('admin_partner_index').'?id='.$params['id'].'&delete=1');
} else {
    header('Location: ' . $router->url('admin_partner_index').'?id='.$params['id'].'&delete=0');
}

?>