<?php
session_start();
require '../database/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est authentifié et s'il est vétérinaire
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'vet') {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Récupération des données de consommation triées par date
$stmt = $pdo->query("SELECT c.*, a.name AS animal_name, a.race AS animal_race, h.name AS habitat_name 
                      FROM consommation c 
                      JOIN animaux a ON c.animal_id = a.id 
                      JOIN habitats h ON a.habitat_id = h.id 
                      ORDER BY c.date DESC"); // Trier par date, décroissant
$consommations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les commentaires des habitats
$comments = $pdo->query("SELECT hc.*, h.name AS habitat_name, u.username AS vet_name 
                          FROM habitat_comments hc 
                          JOIN habitats h ON hc.habitat_id = h.id 
                          JOIN users u ON hc.vet_id = u.id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Vétérinaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Espace Vétérinaire</h1>
    <a class="btn btn-primary mt-3" href="create_report.php">Créer un compte rendu</a>
    <a class="btn btn-primary mt-3" href="comment_habitat.php">Commenter un habitat</a>
    <a class="btn btn-primary mt-3" href="give_opinion.php">Avis sur un animal</a>

    <h2>Suivi des Animaux</h2>

    <?php if (count($consommations) > 0): ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Race</th>
                <th>Habitat</th> <!-- Nouvelle colonne pour l'habitat -->
                <th>Date</th>
                <th>Heure</th>
                <th>Type de Nourriture</th>
                <th>Quantité (Kg)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($consommations as $consommation): ?>
                <tr>
                    <td><?= htmlspecialchars($consommation['id']) ?></td>
                    <td><?= htmlspecialchars($consommation['animal_name']) ?></td>
                    <td><?= htmlspecialchars($consommation['animal_race']) ?></td>
                    <td><?= htmlspecialchars($consommation['habitat_name']) ?></td> <!-- Affichage de l'habitat -->
                    <td><?= htmlspecialchars($consommation['date']) ?></td>
                    <td><?= htmlspecialchars($consommation['heure']) ?></td>
                    <td><?= htmlspecialchars($consommation['type_nourriture']) ?></td>
                    <td><?= htmlspecialchars($consommation['quantite']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune consommation enregistrée.</p>
    <?php endif; ?>

    <h2>Commentaires sur les Habitats</h2>
    <ul class="list-group">
        <?php foreach ($comments as $comment): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($comment['habitat_name']) ?></strong> - Commenté par <?= htmlspecialchars($comment['vet_name']) ?> le <?= htmlspecialchars($comment['created_at']) ?>
                <p><?= htmlspecialchars($comment['comment']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <a class="btn btn-danger mt-3" href="../public/logout.php">Se déconnecter</a>
</div>
</body>
</html>
