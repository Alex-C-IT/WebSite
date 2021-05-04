<?php

use App\Auth;
use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Helpers\ObjectHelper;
use App\Validators\CategoryValidator;
use App\Repository\CategoryRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Édition d'une catégorie";
$success = false;

// Connexion à la BDD
$pdo = Connection::getPDO();

// Récupération des données de l'article
$categoryRepository = new CategoryRepository($pdo);
$category = $categoryRepository->find($params['id']);

// Édition soumise ?
$errors = [];
if (!empty($_POST)) {
    $v = new CategoryValidator($_POST, $categoryRepository, $category->getID());
    ObjectHelper::hydrate($category, $_POST, ['name', 'slug', 'color']);
    if ($v->validate()) {
        $categoryRepository->update([
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'color' => $category->getColor()
        ], $category->getID());
        $success = true;
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($category, $errors);

?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        La catégorie a bien été enregistrée !
    </div>
<?php endif ?>

<?php if($success): ?>
    <div class="alert alert-success">
        La modification de la catégorie <strong>#<?= $category->getId(); ?></strong> été correctement exécutée.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu être modifiée, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Édition de la catégorie #<?= e($category->getID()); ?> - <?= e($category->getName()); ?></h1>

<?php require '_form.php'; ?>