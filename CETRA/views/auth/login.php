<?php 

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Model\User;
use App\Repository\UserRepository;
use App\Repository\Exception\UserNotFoundException;

if(Auth::checkUserConnected() === true) {
    header('Location: '. $router->url('admin_post_index'));
}

$user = new User();
$errors = [];

if(!empty($_POST)) {

    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $userRepository = new UserRepository(Connection::getPDO());
        try {
            $u = $userRepository->findByUsername($_POST['username']);
            if (password_verify($_POST['password'], $u->getPassword()) === true) {
                
                if(session_status() ===  PHP_SESSION_NONE) session_start();

                $_SESSION['auth']['id'] = $u->getID();
                $_SESSION['auth']['username'] = $u->getUsername();
                $_SESSION['auth']['role'] = $u->getTypeUser();
                if($_SESSION['auth']['role'] === "ADMIN") {
                    header('Location:' . $router->url('admin_home'));
                } else {
                    header('Location:' . $router->url('espaceperso_home'));
                }
                exit();
            }
        } catch (UserNotFoundException $e) {
        }
    }
}

$form = new Form($user, $errors);

?>

<h1>Connexion</h1>

<?php if(isset($_GET['fordidden'])): ?>
    <div class="alert alert-danger">
        Vous ne pouvez pas accéder à cette page.
    </div>
<?php endif ?>

<form action="" method="POST">
    <?= $form->input('username', 'Nom d\'utilisateur'); ?>
    <?= $form->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>