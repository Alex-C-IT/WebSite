<?php

use App\Connection;
use App\Repository\CategoryRepository;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$faker = Faker\Factory::create('fr_FR');

try {
    $pdo = Connection::getPDO(); 
} catch (Exception $e) {
    die($e->getMessage());
}

$categoryRepository = new CategoryRepository($pdo);
$categoryRepository->update(['name' => '360', 'slug' => 'euragro-360'], 1);
$categoryRepository->update(['name' => 'Logistique', 'slug' => 'euragro-logistique'], 2);
$categoryRepository->update(['name' => 'WMS', 'slug' => 'euragro-wms'], 3);
$categoryRepository->update(['name' => 'Caisse', 'slug' => 'euragro-caisse'], 4);
$categoryRepository->update(['name' => 'Lab', 'slug' => 'euragro-lab'], 5);

?>