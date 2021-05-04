<form action="" method="POST">
    <?= $form->input('object', 'Objet'); ?>
    <?= $form->textarea('content', 'Texte', 10); ?>
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>