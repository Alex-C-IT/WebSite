<form action="" method="POST">
    <?= $form->textarea('contentAnswer', 'Réponse', 10); ?>
    <button type="submit" class="btn btn-primary">Soumettre la réponse</button>
    <a href="<?= $router->url('admin_ticket_index'); ?>" class="btn btn-primary">Retour</a>
</form>