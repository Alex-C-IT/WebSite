<?php

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Model\Post;
use App\Helpers\ObjectHelper;
use App\Validators\PostValidator;
use App\Attachment\PostAttachment;
use App\Repository\{PostRepository, CategoryRepository};

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 
        
$title = "Création d'un article";

$errors = [];
$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

//Récupérer les catégories 
$pdo = Connection::getPDO();
$categoryRepository = new CategoryRepository($pdo);
$categories = $categoryRepository->list();

// Création d'un article soumise ?
if (!empty($_POST)) {
    $postRepository = new PostRepository($pdo);
    $data = array_merge($_POST, $_FILES);
    $v = new PostValidator($data, $postRepository, $post->getID(), $categories);
    ObjectHelper::hydrate($post, $data, ['name', 'slug', 'content', 'createdAt', 'image']);
    if ($v->validate()) {
        //Ajout de l'article
        $pdo->beginTransaction();
        PostAttachment::upload($post);
        $postRepository->insertPost($post);
        $postRepository->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryRepository->addPostsCategories([$post]);
        $success = true;
        // Redirection vers la page d'édition de l'article
        header('Location: ' . $router->url('admin_post_edit', ['id' => $post->getID()]) . '?created=1');
        die();
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($post, $errors);

?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être enregistré, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Création d'un nouvel article</h1>

<?php require '_form.php'; ?>

