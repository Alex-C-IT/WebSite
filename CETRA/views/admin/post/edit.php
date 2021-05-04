<?php

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Helpers\ObjectHelper;
use App\Validators\PostValidator;
use App\Attachment\PostAttachment;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Édition d'un article";
$success = false;

// Connexion à la BDD
$pdo = Connection::getPDO();

// Récupération des données de l'article
$postRepository = new PostRepository($pdo);
$post = $postRepository->find($params['id']);

//Récupérer les catégories 
$categoryRepository = new CategoryRepository($pdo);
$categories = $categoryRepository->list();
$categoryRepository->addPostsCategories([$post]);

// Édition soumise ?
$errors = [];
if (!empty($_POST)) {
    $data = array_merge($_POST, $_FILES);
    $v = new PostValidator($data, $postRepository, $post->getID(), $categories);
    ObjectHelper::hydrate($post, $data, ['name', 'slug', 'content', 'createdAt', 'image']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        PostAttachment::upload($post);
        $postRepository->updatePost($post);
        $postRepository->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryRepository->addPostsCategories([$post]);
        $success = true;
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($post, $errors);

?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article a bien été enregistré !
    </div>
<?php endif ?>

<?php if($success): ?>
    <div class="alert alert-success">
        La modification de l'article <strong>#<?= $post->getId(); ?></strong> été correctement exécutée.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Édition de l'article #<?= e($post->getID()); ?></h1>

<?php require '_form.php'; ?>