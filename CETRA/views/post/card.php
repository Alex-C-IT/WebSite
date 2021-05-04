<div class="card border-light mb-3" style="max-width: 20rem; min-height: 400px;">
    <div class="card-header bg-Secondary font-weight-bold" style="min-height: 75px;"><?= $post->getName(); ?></div>
    <div class="card-body">
        <?php if ($post->getImage()): ?>
            <img src="<?= $post->getImageURL('small') ?>" class="card-img-top" width="100%">
        <?php else: ?>
            <img src="https://via.placeholder.com/213x71" alt="En-tête" width="100%" />
        <?php endif ?>
        <p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d F Y'); ?></p>
        <?php if(!empty($post->getCategories())): ?>
            <p>
                <?php foreach($post->getCategories() as $category): ?>
                    <?php $linkCategory = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]); ?>
                    <a href="<?= $linkCategory ?>" class="badge badge-pill" style="color: #FFF; background-color: <?= $category->getColor(); ?>;"><?= $category->getName(); ?></a>
                <?php endforeach ?>
            </p>
        <?php endif ?>
        <p><?= trim($post->getExcerpt()); ?></p>
    </div>
    <div class="card-footer text-muted">
        <a href="<?= $post->getPostURL($router); ?>" class="btn btn-primary">Voir plus</a>
    </div>
</div>