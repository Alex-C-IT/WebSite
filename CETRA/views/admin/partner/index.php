<?php

use App\Auth;
use App\Connection;
use App\Repository\PartnerRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Administration - Partenaires";

// Connexion à la base de données
$pdo = Connection::getPDO();

// Récupération des partenaires
$partners = (new PartnerRepository($pdo))->findAll();

$delete = isset($_GET['delete']) ? $_GET['delete'] : null;
$create = isset($_GET['created']) ? $_GET['created'] : null;
?>

<?php if($delete): ?>
    <div class="alert alert-dismissible alert-success">
        <strong>Le partenaire #<?= isset($_GET['id']) ? $_GET['id'] : ''; ?></strong> a été correctement supprimé !
    </div>  
<?php endif ?>


<h1>Administration - Gestion des partenaires</h1>

<table class="table table-hover">
<a href="<?= $router->url('admin_partner_new'); ?>"><button class="btn btn-success mb-3 mt-3">Ajouter un partenaire</button></a>
    <thead>
        <tr>
            <th scope="col">Logo</th>
            <th scope="col">Partenaire</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($partners as $partner): ?>
        <tr>
            <th scope="row"><img src="<?= $partner->getImageURL('small'); ?>" alt="Logo" /></th>
            <td class="text-dark"><a href="<?= $router->url('partner', ['id' => $partner->getId(), 'slug' => $partner->getSlug()]); ?>" target="_blanck"><?= $partner->getName(); ?></a></td>
            <td>
                <a class="btn btn-warning btn-sm" href="<?= $router->url('admin_partner_edit', ['id' => $partner->getId()]); ?>">Éditer</a>
                
                <form class="d-inline" action="<?= $router->url('admin_partner_delete', ['id' => $partner->getId()]) ?>" 
                    onsubmit='return confirm("Confirmez-vous la suppression de ce partenaire ?");' method="POST">
                    <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
