<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../database/db.php'; // Connexion à la base de données
require_once '../database/auth.php'; // Inclure l'authentification si nécessaire

// Vérifiez si l'utilisateur est connecté et a le bon rôle
if (!isAuthenticated() || !isAdmin()) {
    header('Location: ../login.php');
    exit();
}

// Récupérer le paramètre de tri de l'URL
$order = 'DESC'; // Tri par défaut
if (isset($_GET['sort']) && $_GET['sort'] === 'asc') {
    $order = 'ASC';
}

// Utiliser le bon objet de connexion
try {
    $reports = $pdo->query("SELECT reports.*, animaux.name AS animal_name, animaux.race AS animal_race, 
                                    habitats.name AS habitat_name, users.username AS vet_name 
                             FROM reports 
                             JOIN animaux ON reports.animal_id = animaux.id 
                             JOIN habitats ON animaux.habitat_id = habitats.id 
                             JOIN users ON reports.vet_id = users.id 
                             ORDER BY reports.created_at $order")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur dans la requête : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Comptes Rendus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-group .btn {
            margin: 0 5px; /* Espacement entre les boutons */
        }
    </style>
</head>
<body>
<div class="container">
    <?php include 'navbar.php'; ?>

    <h2>Comptes Rendus des Vétérinaires</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Animal</th>
            <th>Race</th>
            <th>Habitat</th> <!-- Nouvelle colonne pour l'habitat -->
            <th>Vétérinaire</th>
            <th>Compte Rendu</th>
            <th>Date</th>
            <th>
                <div class="btn-group" role="group" aria-label="Tri par date">
                    <a href="?sort=asc" class="btn btn-outline-primary">Date &#9650;</a>
                    <a href="?sort=desc" class="btn btn-outline-primary">Date &#9660;</a>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($reports)): ?>
            <tr>
                <td colspan="7" class="text-center">Aucun compte rendu disponible.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['id']) ?></td>
                    <td><?= htmlspecialchars($report['animal_name']) ?></td>
                    <td><?= htmlspecialchars($report['animal_race']) ?></td>
                    <td><?= htmlspecialchars($report['habitat_name']) ?></td> <!-- Affichage de l'habitat -->
                    <td><?= htmlspecialchars($report['vet_name']) ?></td>
                    <td><?= htmlspecialchars($report['report_text']) ?></td>
                    <td><?= htmlspecialchars($report['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
