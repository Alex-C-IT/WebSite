<form action="" method="POST">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('color', 'Couleur'); ?>
    <button type="submit" class="btn btn-primary">
        <?php if($category->getID() !== null): ?>
        Éditer
        <?php else: ?>
        Créer
        <?php endif; ?>
    </button>
</form>