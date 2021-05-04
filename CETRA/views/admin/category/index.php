<?php

use App\Auth;
use App\Connection;
use App\Repository\CategoryRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Administration - Catégories";

// Connexion à la base de données
$pdo = Connection::getPDO();

// Récupération des catégories
$categories = (new CategoryRepository($pdo))->findAll();

$ok = isset($_GET['delete']) ? $_GET['delete'] : null;
?>

<?php if($ok): ?>
    <div class="alert alert-dismissible alert-success">
        <strong>La catégorie #<?= isset($_GET['id']) ? $_GET['id'] : ''; ?></strong> a été correctement supprimée !
    </div>  
<?php endif ?>

<h1>Administration - Gestion des catégories</h1>

<table class="table table-hover">
<a href="<?= $router->url('admin_category_new'); ?>"><button class="btn btn-success mb-3 mt-3">Ajouter une categorie</button></a>
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Catégories</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category): ?>
        <tr>
            <th scope="row">#<?= $category->getId(); ?></th>
            <td class="text-dark"><a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]); ?>"><?= $category->getName(); ?></a></td>
            <td>
                <a class="btn btn-warning btn-sm" href="<?= $router->url('admin_category_edit', ['id' => $category->getId()]); ?>">Éditer</a>
                
                <form class="d-inline" action="<?= $router->url('admin_category_delete', ['id' => $category->getId()]); ?>" 
                    onsubmit='return confirm("Confirmez-vous la suppression de cette catégorie ?");' method="POST">
                    <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
