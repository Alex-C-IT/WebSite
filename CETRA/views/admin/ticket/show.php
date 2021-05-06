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
    
$id = (int)$params['id'];
$slug = $params['slug'];

//Connexion à la base de données
$pdo = Connection::getPDO();

// Récupération du ticket
$ticket = (new TicketRepository($pdo))->find($id);

if($ticket === null)
{
    echo "Aucun ticket trouvé";
    http_response_code(301);
    header('Location: ' . $router->url('admin_ticket_index'));
    die();
}

if($ticket->getSlug() !== $slug) {
    $url = $router->url('partner', ['slug' => $ticket->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
    die();
}

$title = "Ticket " .  $ticket->getId();
?>

<div class="card border-primary mb-3" style="max-width: 100rem;">
  <div class="card-header"><h1>Ticket #<?= $id ?></h1></div>
  <div class="card-body">
    <h4 class="card-title">Objet : <?= $ticket->getObject() ?></h4>
    <p class="card-text">
        <h4>Message :</h4>
        <?= $ticket->getContent(); ?>
    </p>
  </div>
</div>
<div class="card border-success mb-3" style="max-width: 100rem;">
  <div class="card-header"><h1>Réponse</h1></div>
  <div class="card-body">
    <p class="card-text">
        <?= $ticket->getContentAnswer() === null ? "<p><b>Ce ticket n'est pas encore traité.</b></p>" : "<p>{$ticket->getContentAnswer()}</p>"; ?>
    </p>
  </div>
</div>
<a href="<?= $router->url('admin_ticket_index', ['id' => $ticket->getId(), 'slug' => $ticket->getSlug()]); ?>"><button class="btn btn-primary">Retour à la liste des tickets</button></a>
