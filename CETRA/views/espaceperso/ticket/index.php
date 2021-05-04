<?php

use App\Auth;
use App\Connection;
use App\Repository\TicketRepository;

if(!Auth::checkUserConnected())
    header('Location: '. $router->url('app_login'));

//Connexion à la base de données
$pdo = Connection::getPDO();

// Récupération des tickets
$tickets = (new TicketRepository($pdo))->findAllByAccountId($_SESSION['auth']['id']);
dump($tickets);
$title = "Espace personnel - Tickets";
?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        Votre ticket a bien été envoyé. Vous recevrez une réponse sous peu.
    </div>
<?php endif ?>


<h1>Tickets</h1>

<a href="<?= $router->url('espaceperso_ticket_new') ?>"><button class="btn btn-success mb-3 mt-3">Envoyer un ticket</button></a>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#en_cours">Tickets en cours</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#resolus">Historique tickets traités</a>
  </li>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active show" id="en_cours">
    <br><br><br>
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
                        <a href="#"><button class="btn btn-success btn-sm">Visualiser</button></a>
                        <form class="d-inline" action="<?= $router->url('espaceperso_ticket_delete', ['id' => $ticket->getId()]); ?>" onsubmit='return confirm("Confirmez-vous la suppression de ce ticket ?");' method="POST">
                            <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
        </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="resolus">
  <br><br><br>
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
                    <td><a href="#"><button class="btn btn-warning btn-sm">Visualiser</button></a></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
        </tbody>
    </table>
  </div>
</div>