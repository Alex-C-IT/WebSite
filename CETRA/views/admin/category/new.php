<?php

use App\Auth;
use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Model\Category;
use App\Helpers\ObjectHelper;
use App\Validators\CategoryValidator;
use App\Repository\CategoryRepository;

if(Auth::checkUserConnected()) {
    if(isset($_SESSION['auth']['role']))
        if($_SESSION['auth']['role'] !== 'ADMIN')
            header('Location: '. $router->url('app_login'));
} else {
    header('Location: '. $router->url('app_login'));
} 


$title = "Création d'une catégorie";
$errors = [];
$category = new Category();

// Création d'une catégorie soumise ?
if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $categoryRepository = new CategoryRepository($pdo);
    $v = new CategoryValidator($_POST, $categoryRepository);
    ObjectHelper::hydrate($category, $_POST, ['name', 'slug', 'color']);
    if ($v->validate()) {
        $categoryRepository->insert([
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'color' => $category->getColor()
        ]);
        // Redirection
        header('Location: ' . $router->url('admin_category_index') . '?created=1');
        die();
    } else {
        $errors = $v->errors();
    }  
}

// Formulaires
$form = new Form($category, $errors);

?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La categorie n'a pas pu être enregistrée, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Création d'une nouvelle catégorie</h1>

<?php require '_form.php'; ?>

