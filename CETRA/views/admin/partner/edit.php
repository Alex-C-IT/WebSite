<?php

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Helpers\ObjectHelper;
use App\Validators\PartnerValidator;
use App\Attachment\PartnerAttachment;
use App\Repository\PartnerRepository;


if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Édition d'un partenaire";
$success = false;

// Connexion à la BDD
$pdo = Connection::getPDO();

// Récupération des données de l'article
$partnerRepository = new PartnerRepository($pdo);
$partner = $partnerRepository->find($params['id']);

// Édition soumise ?
$errors = [];
if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $data = array_merge($_POST, $_FILES);
    $partnerRepository = new PartnerRepository($pdo);
    $v = new PartnerValidator($data, $partnerRepository, $partner->getId());
    ObjectHelper::hydrate($partner, $data, ['name', 'slug', 'webSite', 'street', 'city', 'postalCode', 'image','description', 'mapGoogle']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        PartnerAttachment::upload($partner);
        $partnerRepository->updatePartner($partner);
        $pdo->commit();
        $success = true;
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($partner, $errors);

?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        Le partenaire a bien été enregistrée !
    </div>
<?php endif ?>

<?php if($success): ?>
    <div class="alert alert-success">
        La modification de la catégorie <strong>#<?= $partner->getId(); ?></strong> été correctement exécutée.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Le partenaire n'a pas pu être modifié, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Édition du partenaire #<?= e($partner->getID()); ?> - <?= e($partner->getName()); ?></h1>

<?php require '_form.php'; ?>