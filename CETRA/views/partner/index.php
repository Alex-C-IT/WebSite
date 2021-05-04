<?php 

use App\Connection;
use App\Repository\PartnerRepository;

$title = "Partneraires"; 
$pdo = Connection::getPDO();
$partnerRepository = new PartnerRepository($pdo);
$partners = $partnerRepository->findAll();
$link = $router->url('partner'); 

?>

<h1>Partenaires</h1>

<div class="row mt-5">
    <?php foreach($partners as $partner): ?>
        <div class="col-md d-flex align-items-center flex-column mb-2">
            <?php require 'card.php'; ?>
        </div>
    <?php endforeach ?>
</div>
