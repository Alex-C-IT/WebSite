<form action="" method="POST" enctype="multipart/form-data">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <div class="row">
        <div class="col-md-9">
            <?= $form->file('image', 'Image d\'en-tête'); ?>
        </div>
        <div class="col-md-3">
            <?php if ($post->getImage()): ?>
                <img src="<?= $post->getImageURL('small') ?>" alt="" style="width: 100%;">
            <?php endif ?>
        </div>
    </div>
    <?= $form->select('categories_ids', 'Categories', $categories, $post, "Categories"); ?>
    <?= $form->textarea('content', 'Texte', 20); ?>
    <?= $form->input('createdAt', 'Créé le'); ?>
    <button type="submit" class="btn btn-primary">
        <?php if($post->getID() !== null): ?>
        Éditer
        <?php else: ?>
        Créer
        <?php endif; ?>
    </button>
</form>