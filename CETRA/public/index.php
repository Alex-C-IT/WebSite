<?php 
require '../vendor/autoload.php';
use App\Router;


// Constantes
define("NB_ARTICLES_PER_PAGE", 12);
define('UPLOAD_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'uploads');
/******************\
 * BLOC DEBUG DEV *
 ******************/
define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
// ***** FIN BLOC DEBUG DEV ******************************* //

if(isset($_GET['page']) && $_GET['page'] == 1) {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        $get = $_GET;
        unset($get['page']);
        $query = http_build_query($get);
        if (!empty($query)) {
                $uri = $uri . '?' . $query;
        }
        http_response_code(301);
        header('Location: ' . $uri);
        exit();
}

$router = new Router(dirname(__DIR__) . DIRECTORY_SEPARATOR .'views');
$router 
        ->get('/', 'index', 'app_home')                                                                 // Page d'accueil
        ->get('/actualites', 'post/index', 'user_post_index')                                           // Page des actualités
        ->get('/actualite/category/[*:slug]-[i:id]', 'category/show', 'category')                       // Une catégorie
        ->get('/actualite/[*:slug]-[i:id]', 'post/show', 'post')                                        // Un article
        ->get('/partner/[*:slug]-[i:id]', 'partner/show', 'partner')                                    // Un partenaire
        ->get('/cetra', 'cetra', 'app_cetra')                                                           // Page de la société
        ->get('/euragro/euragro', 'euragro/euragro', 'app_euragro_euragro')                             // Page EURAGRO
        ->get('/euragro/mobilite', 'euragro/mobilite', 'app_euragro_mobilite')                          // Page EURAGRO Mobilié
        ->get('/euragro/caisse', 'euragro/caisse', 'app_euragro_caisse')                                // Page EURAGRO CAISSE
        ->get('/euragro/lab', '/euragro/lab', 'app_euragro_lab')                                        // Page EURAGRO LAB
        ->get('/prestations', 'prestations', 'app_prestations')                                         // Page des prestations
        ->get('/metiers', 'metiers', 'app_metiers')                                                     // Page des métiers
        ->get('/partenaires', 'partner/index', 'app_partner_index')                                     // Page des partenaires
        ->get('/partenaires/[*:slug]-[i:id]', 'partner/show', 'app_partner_show')                       // Page des partenaires
        ->get('/mentions', 'mentions', 'app_mentions')                                                  // Page des mentions légales
        ->get('/espaceclient/login', 'customer/login', 'app_espace_client_login')                       // Page de connexion espace client
        //Connexion
        ->match('/auth/login', 'auth/login', 'app_login')                                               // Page de connexion
        ->post('/auth/logout', 'auth/logout', 'app_logout')                                             // Page de deconnexion
        // Espace client
        ->get('/espaceperso/accueil', 'espaceperso/index', 'espaceperso_home')                          // Accueil espace perso
        // Tickets
        ->get('/espaceperso/ticket/[*:slug]-[i:id]', 'ticket/show', 'ticket')                           // Un ticket
        ->get('/espaceperso/tickets', 'espaceperso/ticket/index', 'espaceperso_ticket_index')           // Liste des tickets espace personnel (par client)
        ->match('/espaceperso/ticket/new', 'espaceperso/ticket/new', 'espaceperso_ticket_new')          // Page création nouveau ticket
        ->post('/espaceperso/ticket/[i:id]/delete', 'espaceperso/ticket/delete', 'espaceperso_ticket_delete') // Suppression d'un ticket
        // Espace administration
        ->get('/admin/accueil', 'admin/index', 'admin_home')                                            // Accueil page d'administration
        //Articles 
        ->get('/admin/actualites', 'admin/post/index', 'admin_post_index')
        ->match('/admin/actualite/[i:id]/edit', 'admin/post/edit', 'admin_post_edit')
        ->post('/admin/actualite/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
        ->match('/admin/actualite/new', 'admin/post/new', 'admin_post_new')
        // Catégories
        ->get('/admin/categories', 'admin/category/index', 'admin_category_index')
        ->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete')
        ->match('/admin/category/[i:id]/edit', 'admin/category/edit', 'admin_category_edit')
        ->match('/admin/category/new', 'admin/category/new', 'admin_category_new')
        // Partenaires
        ->get('/admin/partners', 'admin/partner/index', 'admin_partner_index')
        ->post('/admin/partner/[i:id]/delete', 'admin/partner/delete', 'admin_partner_delete')
        ->match('/admin/partner/[i:id]/edit', 'admin/partner/edit', 'admin_partner_edit')
        ->match('/admin/partner/new', 'admin/partner/new', 'admin_partner_new')
        ->run();
?>