<form action="" method="POST" enctype="multipart/form-data">
    <?= $form->input('name', 'Nom'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('webSite', 'Site web'); ?>
    <?= $form->input('street', 'Rue'); ?>
    <?= $form->input('city', 'Ville'); ?>
    <?= $form->input('postalCode', 'Code Postal'); ?>
    <div class="row">
        <div class="col-md-9">
            <?= $form->file('image', 'Logo'); ?>
        </div>
        <div class="col-md-3">
            <?php if ($partner->getImage()): ?>
                <img src="<?= $partner->getImageURL('small') ?>" alt="" style="width: 100%;">
            <?php endif ?>
        </div>
    </div>
    <?= $form->textarea('description', 'Description', 10); ?>
    <?= $form->textarea('mapGoogle', 'Iframe Google Map', 2); ?>
    <button type="submit" class="btn btn-primary">
        <?php if($partner->getID() !== null): ?>
        Éditer
        <?php else: ?>
        Créer
        <?php endif; ?>
    </button>
</form>