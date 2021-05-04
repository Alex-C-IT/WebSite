<?php

use App\Attachment\PartnerAttachment;
use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Model\Partner;
use App\Helpers\ObjectHelper;
use App\Validators\PartnerValidator;
use App\Repository\PartnerRepository;


if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Création d'un nouveau partenaire";
$errors = [];
$partner = new Partner();

// Création d'une catégorie soumise ?
if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $data = array_merge($_POST, $_FILES);
    $partnerRepository = new PartnerRepository($pdo);
    $v = new PartnerValidator($data, $partnerRepository);
    ObjectHelper::hydrate($partner, $data, ['name', 'slug', 'webSite', 'street', 'city', 'postalCode', 'image','description', 'mapGoogle']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        PartnerAttachment::upload($partner);
        $partnerRepository->insertPartner($partner);
        $pdo->commit();
        // Redirection
        header('Location: ' . $router->url('admin_partner_edit', ['id' => $partner->getId()]) . '?created=1');
        die();
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($partner, $errors);

?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Le partenaire n'a pas pu être enregistré, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Création d'un partenaire</h1>

<?php require '_form.php'; ?>