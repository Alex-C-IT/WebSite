<?php

use App\Auth;
use App\Helpers\LinkHelper; ?>

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
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a href="<?= $router->url('app_home'); ?>" class="navbar-brand"><img src="/images/cetra_longueur_petit.png" alt="logo CETRA"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_home')) ? "active" : "" ?>" href="<?= $router->url('app_home') ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('user_post_index')) ? "active" : "" ?>" href="<?= $router->url('user_post_index') ?>">Actualités</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_cetra')) ? "active" : "" ?>" href="<?= $router->url('app_cetra') ?>">CETRA</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Produits</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?php echo LinkHelper::isActive($_SERVER, $router->url('app_euragro_euragro')) ? "active" : "" ?>" href="<?= $router->url('app_euragro_euragro') ?>">EURAGRO</a>
                        <a class="dropdown-item <?php echo LinkHelper::isActive($_SERVER, $router->url('app_euragro_mobilite')) ? "active" : "" ?>" href="<?= $router->url('app_euragro_mobilite') ?>">EURAGRO Mobilité</a>
                        <a class="dropdown-item <?php echo LinkHelper::isActive($_SERVER, $router->url('app_euragro_caisse')) ? "active" : "" ?>" href="<?= $router->url('app_euragro_caisse') ?>">EURAGRO CAISSE</a>
                        <a class="dropdown-item <?php echo LinkHelper::isActive($_SERVER, $router->url('app_euragro_lab')) ? "active" : "" ?>" href="<?= $router->url('app_euragro_lab') ?>">EURAGRO LAB</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_prestations')) ? "active" : "" ?>" href="<?= $router->url('app_prestations') ?>">Prestations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_metiers')) ? "active" : "" ?>" href="<?= $router->url('app_metiers') ?>">Métiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_partner_index')) ? "active" : "" ?>" href="<?= $router->url('app_partner_index') ?>">Partenaires</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_mentions')) ? "active" : "" ?>" href="<?= $router->url('app_mentions') ?>">A propos</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                <?php if(Auth::checkUserConnected() == false): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('app_login')) ? "active" : "" ?>" href="<?= $router->url('app_login') ?>">Connexion</a>
                    </li>
                <?php else: ?>
                    <?php if(isset($_SESSION['auth']['role'])) : ?>
                        <?php if($_SESSION['auth']['role'] === "ADMIN"): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('admin_home')) ? "active" : "" ?>" href="<?= $router->url('admin_home') ?>">Administration</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo LinkHelper::isActive($_SERVER, $router->url('espaceperso_home')) ? "active" : "" ?>" href="<?= $router->url('espaceperso_home') ?>">Espace perso</a>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                    <form class="form-inline my-2 my-lg-0" method="POST" action="<?= $router->url('app_logout'); ?>">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <button type="submit" class="nav-link" style="background:transparent; border:none;">Déconnexion</button>
                            </li>
                        </ul>
                    </form>
                <?php endif ?>
                </ul>
            </form>
        </div>
    </nav>
    <div class="container" style="margin-top: 100px;">
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