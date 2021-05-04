<?php 

use App\Connection;
use App\Helpers\TextHelper;
use App\Repository\PartnerRepository;

$id = (int)$params['id'];
$slug = $params['slug'];

//Connexion à la base de données
$pdo = Connection::getPDO();
// Récupération de l'article
$partner = (new PartnerRepository($pdo))->find($id);

if($partner->getSlug() !== $slug) {
    $url = $router->url('partner', ['slug' => $partner->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
    die();
}

$title = "Partenaire " .  $partner->getName();
?>

<div class="row">
    <div class="col col-lg-4">
        <?php if ($partner->getImage()): ?>
            <img src="<?= $partner->getImageURL('large') ?>" alt="Logo" width="100%" style="margin-top:20%;">
        <?php else: ?>
            <img src="https://via.placeholder.com/400x180" alt="image" width="100%">
        <?php endif ?>
        <h1><?= $partner->getName(); ?></h1>
        <p><?= $partner->getStreet(); ?></p>
        <p><?= $partner->getPostalCode() . ' ' . $partner->getCity(); ?></p>
        <p><a href="<?= $partner->getWebSite(); ?>"><?= $partner->getWebSite(); ?></a></p>
        <p><?= $partner->getDescription(); ?></p>
    </div>
    <div class="col col-lg mt-5 ml-5">
        <?= TextHelper::noScript($partner->getMapGoogle()); ?>
    </div>
</div>
