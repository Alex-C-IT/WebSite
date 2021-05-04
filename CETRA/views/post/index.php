<?php 

use App\Connection;
use App\Repository\PostRepository;

$title = "Page d'accueil"; 

$pdo = Connection::getPDO();

$postRepository = new PostRepository($pdo);
[$posts, $paginated] = $postRepository->findPaginated();

$link = $router->url('user_post_index'); 

?>

<h1>Actualités</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
        <div class="col-md-3 d-flex align-items-center flex-column min-h-200">
            <?php require 'card.php'; ?>
        </div>
    <?php endforeach ?>
</div>

<div class="row d-flex justify-content-between my-4">
    <?= $paginated->previousLink($link); ?>
    <?= $paginated->nextLink($link); ?>
</div>

