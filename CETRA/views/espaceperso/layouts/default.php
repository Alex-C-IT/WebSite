<?php use App\Helpers\LinkHelper; ?>

<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="<?= $router->url('app_home'); ?>" class="navbar-brand"><img src="/images/cetra_longueur_petit.png" alt="logo CETRA"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('espaceperso_home')) ? "active" : "" ?>" href="<?= $router->url('espaceperso_home') ?>">Tableau de bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('espaceperso_ticket_index')) ? "active" : "" ?>" href="<?= $router->url('espaceperso_ticket_index') ?>">Tickets</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="POST" action="<?= $router->url('app_logout'); ?>">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <button type="submit" class="nav-link" style="background:transparent; border:none;">Déconnexion</button>
                    </li>
                </ul>
            </form>
        </div>
    </nav>
    <div class="container mt-4">
        <?= $content ?>
    </div>
    
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            <?php if(defined('DEBUG_TIME')): ?>
                Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)); ?> ms
            <?php endif ?>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>