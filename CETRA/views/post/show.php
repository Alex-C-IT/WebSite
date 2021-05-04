<?php 

use App\Connection;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;

$id = (int)$params['id'];
$slug = $params['slug'];

//Connexion à la base de données
$pdo = Connection::getPDO();
// Récupération de l'article
$post = (new PostRepository($pdo))->find($id);
// Ajout des catégories associées à l'article
(new CategoryRepository($pdo))->addPostsCategories([$post]);

if($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
    die();
}

$title = "Article " .  $post->getName();

?>

<h1><?= $post->getName(); ?></h1>
<p><em><?= $post->getCreatedAt()->format('d F Y'); ?></em></p>
<p>
    <?php foreach($post->getCategories() as $category): ?>
        <?php $categoryURL = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]); ?>
        <a href="<?= $categoryURL ?>" class="badge badge-pill" style="color: #FFF; background-color: <?= $category->getColor(); ?>;"><?= $category->getName(); ?></a>
    <?php endforeach ?>
</p>
<?php if ($post->getImage()): ?>
<p>
    <img src="<?= $post->getImageURL('large') ?>" style="width: 100%">
</p>
<?php endif ?>
<p>
    <?= $post->getFormatedContent(); ?>
</p>