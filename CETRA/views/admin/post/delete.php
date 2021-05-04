<?php

use App\Attachment\PostAttachment;
use App\Auth;
use App\Connection;
use App\Repository\PostRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 

$title = "Suppression d'un article";

$pdo = Connection::getPDO();
$postRepository = new PostRepository($pdo);
$post = $postRepository->find($params['id']);
PostAttachment::detach($post);
$success = $postRepository->delete($params['id']);

if($success) {
    header('Location: ' . $router->url('admin_post_index').'?id='.$params['id'].'&delete=1');
} else {
    header('Location: ' . $router->url('admin_post_index').'?id='.$params['id'].'&delete=0');
}

?>