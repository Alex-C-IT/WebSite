<?php

use App\Auth;
use App\Connection;
use App\Repository\TicketRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Administration - Tickets";

// Connexion à la base de données
$pdo = Connection::getPDO();

// Récupération des catégories
$tickets = (new TicketRepository($pdo))->findAll();

$ok = isset($_GET['delete']) ? $_GET['delete'] : null;

$nbTicketsEnAttente = 0;
$nbTicketsTraites = 0;
foreach($tickets as $ticket) 
    if($ticket->getResolved() === false)
        $nbTicketsEnAttente++;
    else
        $nbTicketsTraites++;
?>

<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-danger">
        <?= ($_GET['delete'] == 1) ? "Le ticket #{$_GET['id']} a bien été supprimé." : "Le ticket n°{$_GET['id']} n'a pas pu être supprimé." ?>
    </div>
<?php endif ?>

<h1>Tickets</h1>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#en_cours">Tickets à traiter</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#resolus">Historique tickets traités</a>
  </li>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active show" id="en_cours">
    <br><br><br>
    <?php if($nbTicketsEnAttente !== 0): ?>
    <table class="table table-hover m">
        <thead>
            <tr>
            <th scope="col">N° Ticket</th>
            <th scope="col">Date</th>
            <th scope="col">Objet</th>
            <th scope="col">État</th>
            <th scope="col">#</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($tickets as $ticket): ?>
            <?php if($ticket->getResolved() === false): ?>
                <tr class="table-default">
                    <th scope="row"><?= $ticket->getId() ?></th>
                    <td><?= $ticket->getDateRequestFormated() ?></td>
                    <td><?= e($ticket->getObject()) ?></td>
                    <td>En cours de traitement</td>
                    <td>
                        <a href="<?= $router->url('admin_ticket_reply', ['id' => $ticket->getId(), 'slug' => $ticket->getSlug()]); ?>"><button class="btn btn-success btn-sm">Répondre</button></a>
                        <form class="d-inline" action="<?= $router->url('espaceperso_ticket_delete', ['id' => $ticket->getId()]); ?>" onsubmit='return confirm("Confirmez-vous la suppression de ce ticket ?");' method="POST">
                            <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
        </tbody>
    </table>
    <?php else : ?>
    <p>Aucun ticket à traiter.</p>
    <?php endif ?>
  </div>
  <div class="tab-pane fade" id="resolus">
  <br><br><br>
  <?php if($nbTicketsTraites !== 0): ?>
  <table class="table table-hover m">
        <thead>
            <tr>
            <th scope="col">N° Ticket</th>
            <th scope="col">Date</th>
            <th scope="col">Objet</th>
            <th scope="col">État</th>
            <th scope="col">Traité le</th>
            <th scope="col">#</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($tickets as $ticket): ?>
            <?php if($ticket->getResolved() === true): ?>
                <tr class="table-default">
                    <th scope="row"><?= $ticket->getId() ?></th>
                    <td><?= $ticket->getDateRequestFormated() ?></td>
                    <td><?= e($ticket->getObject()) ?></td>
                    <td>Traité</td>
                    <td><?= $ticket->getDateAnswerFormated() ?></td>
                    <td>
                        <a href="<?= $router->url('admin_ticket_show', ['id' => $ticket->getId(), 'slug' => $ticket->getSlug()]); ?>"><button class="btn btn-warning btn-sm">Visualiser</button></a>
                        <form class="d-inline" action="<?= $router->url('admin_ticket_delete', ['id' => $ticket->getId()]); ?>" onsubmit='return confirm("Confirmez-vous la suppression de ce ticket ?");' method="POST">
                            <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
        </tbody>
    </table>
    <?php else : ?>
    <p>Aucun ticket traité.</p>
    <?php endif ?>
  </div>
</div>