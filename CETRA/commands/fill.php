<?php 

use App\Connection;
use App\Helpers\StyleHelper;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$faker = Faker\Factory::create('fr_FR');

try {
    $pdo = Connection::getPDO(); 
} catch (Exception $e) {
    die($e->getMessage());
}

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE partner');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->date} {$faker->time}', content='{$faker->paragraphs(rand(3, 15), true)}'");
    $posts[] = $pdo->lastInsertId();
}

for($i = 0; $i < 13; $i++) {
    $pdo->exec("INSERT INTO partner SET name='{$faker->sentence(3)}', slug='{$faker->slug}', street='{$faker->streetAddress}', city='$faker->city', postalCode='75000', webSite='$faker->domainName', description='{$faker->paragraphs(rand(1, 3), true)}'");
    $partners[] = $pdo->lastInsertId();
}

for($i = 0; $i < 5; $i++) {
    $color = StyleHelper::randomColor();
    $pdo->exec("INSERT INTO category SET name='{$faker->sentence(3)}', slug='{$faker->slug}', color='{$color}'");
    $categories[] = $pdo->lastInsertId();
}

foreach($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user (username, password) VALUES('admin', '{$password}')");
$password = password_hash('user', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user (username, password) VALUES('user', '{$password}')");
$password = password_hash('alex', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user (username, password) VALUES('alexandre', '{$password}')");