<?php

use App\NumberHelper;
require 'vendor/autoload.php';
$pdo = new PDO("sqlite:./data.sql", null, null, [
PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC,
PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION
]);
$products = $pdo->query("SELECT * FROM products LIMIT 20")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Bien immobiliers</title>
</head>
<body>
    <table class="table table-striped">
        <thead>
            <tr>
               <th>ID</th> 
               <th>Nom</th> 
               <th>Prix</th> 
               <th>Ville</th> 
               <th>Adresse</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td>#<?= $product['id'] ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= NumberHelper::price($product['price'])?></td>
                <td><?= $product['city'] ?></td> 
               <td><?= $product['address'] ?></td> 
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>