<?php

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Helpers\ObjectHelper;
use App\Validators\TicketReplyValidator;
use App\Repository\TicketRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Réponse à un ticket";
$success = false;

// Connexion à la BDD
$pdo = Connection::getPDO();

// Récupération des données de l'article
$ticketRepository = new TicketRepository($pdo);
$ticket = $ticketRepository->find($params['id']);

// Édition soumise ?
$errors = [];
if (!empty($_POST)) {
    $v = new TicketReplyValidator($_POST, $ticketRepository, $ticket->getId());
    ObjectHelper::hydrate($ticket, $_POST, ['contentAnswer']);
    if ($v->validate()) {
        $ticketRepository->update([
            'contentAnswer' => $ticket->getContentAnswer(),
            'dateAnswer' => (new DateTime('now', new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
            'resolved' => 1
        ], $ticket->getId());
        $success = true;
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($ticket, $errors);

$id = $ticket->getId();

?>
<?php if($success): ?>
    <div class="alert alert-success">
        La réponse au ticket <strong>#<?= $id ?></strong> été correctement envoyée.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php dump($errors) ?>
        La réponse n'a pas pu être envoyée, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<div class="card border-primary mb-3" style="max-width: 100rem;">
  <div class="card-header"><h1>Réponse au ticket #<?= $id ?></h1></div>
  <div class="card-body">
    <h4 class="card-title">Objet : <?= $ticket->getObject() ?></h4>
    <p class="card-text">
        <h4>Message :</h4><br>
        <?= $ticket->getContent(); ?>
    </p>
  </div>
</div>

<?php require '_form.php'; ?>