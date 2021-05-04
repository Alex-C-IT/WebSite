<?php

use App\Auth;
use App\Connection;
use App\Repository\PostRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Administration - Articles";

// Connexion à la base de données
$pdo = Connection::getPDO();

// Récupération des articles
[$posts, $paginated] = (new PostRepository($pdo))->findPaginated();

//Lien pagination
$link = $router->url('admin_post_index');

$ok = isset($_GET['delete']) ? $_GET['delete'] : null;
?>

<?php if($ok): ?>
    <div class="alert alert-dismissible alert-success">
        <strong>L'article #<?= isset($_GET['id']) ? $_GET['id'] : ''; ?></strong> a été correctement supprimé !
    </div>  
<?php endif ?>

<h1>Administration - Gestion des articles</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Article</th>
            <th scope="col"><a href="<?= $router->url('admin_post_new'); ?>"><button class="btn btn-success mb-1 mt-1">Ajouter un article</button></a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <th scope="row">#<?= $post->getId(); ?></th>
            <td class="text-dark"><a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>"><?= $post->getName(); ?></a></td>
            <td>
                <a class="btn btn-warning btn-sm" href="<?= $router->url('admin_post_edit', ['id' => $post->getId()]); ?>">Éditer</a>
                
                <form class="d-inline" action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]); ?>" 
                    onsubmit='return confirm("Confirmez-vous la suppression de cet article ?");' method="POST">
                    <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="row d-flex justify-content-between my-4">
    <?= $paginated->previousLink($link); ?>
    <?= $paginated->nextLink($link); ?>
</div>