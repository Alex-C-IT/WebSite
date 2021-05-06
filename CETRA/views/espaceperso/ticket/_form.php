<form action="" method="POST">
    <?= $form->input('object', 'Objet'); ?>
    <?= $form->textarea('content', 'Texte', 10); ?>
    <button type="submit" class="btn btn-primary">Soumettre</button>
    <a href="<?= $router->url('espaceperso_ticket_index'); ?>" class="btn btn-primary">Retour</a>
</form>