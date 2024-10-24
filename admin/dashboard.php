<?php
require '../database/db.php';
require '../database/client.php';

$collection = $client->animal_db->animal_views;
$consultations = $collection->find();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include 'navbar.php';?>
    <h2>Dashboard Administrateur</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nom de l'Animal</th>
            <th>Nombre de Consultations</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($consultations as $consultation) {
            // Récupérer le nom de l'animal à partir de votre base de données d'animaux
            $animalId = $consultation['animal_id'];
            $animal = $pdo->query("SELECT name FROM animaux WHERE id = $animalId")->fetch(PDO::FETCH_ASSOC);
            echo '<tr>';
            echo '<td>' . htmlspecialchars($animal['name']) . '</td>';
            echo '<td>' . htmlspecialchars($consultation['consultations']) . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
