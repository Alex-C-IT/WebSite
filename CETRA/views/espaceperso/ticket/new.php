<?php

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Model\Ticket;
use App\Helpers\ObjectHelper;
use App\Validators\TicketValidator;
use App\Repository\TicketRepository;

if(!Auth::checkUserConnected())
    header('Location: '. $router->url('app_login'));


$title = "Création d'un nouveau ticket";
$errors = [];
$ticket = new Ticket();

// Ticket soumis ?
if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $ticketRepository = new TicketRepository($pdo);
    $v = new TicketValidator($_POST, $ticketRepository);
    ObjectHelper::hydrate($ticket, $_POST, ['object', 'content']);
    $lastId = $pdo->prepare("SELECT MAX(id) FROM ticket")->execute();
    if ($v->validate()) {
        $ticketRepository->insert([
            'object' => $ticket->getObject(),
            'content' => $ticket->getContent(),
            'dateRequest' => (new DateTime('now', new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
            'slug' => "ticket-". $lastId,
            'id_user' => $_SESSION['auth']['id']
        ]);
        // Redirection
        header('Location: ' . $router->url('espaceperso_ticket_index') . '?created=1');
        die();
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($ticket, $errors);

?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Le ticket n'a pas pu être soumis, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Soumission d'un nouveau ticket</h1>

<?php require '_form.php'; ?>