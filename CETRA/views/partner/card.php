<div class="card" style="width: 15rem;">
    <?php if ($partner->getImage()): ?>
        <img src="<?= $partner->getImageURL('small') ?>" class="card-img-top" height="75px">
    <?php else: ?>
        <img src="https://via.placeholder.com/200x65" class="card-img-top" alt="image">
    <?php endif ?>
    <div class="card-body">
        <p class="card-title"><strong><?= $partner->getName(); ?></strong></p>
        <p class="card-subtitle"><a href="<?= $partner->getWebSite(); ?>"><?= $partner->getWebSite(); ?></a><p>
    </div>
    <div class="card-footer text-muted">
        <a href="<?= $router->url('partner', ['id' => $partner->getId(), 'slug' => $partner->getSlug()]) ?>" class="btn btn-primary btn-sm">Voir plus</a>
    </div>
</div>