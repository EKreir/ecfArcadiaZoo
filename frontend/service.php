<?php
require '../database/db.php'; // Connexion à la base de données

// Récupération des services pour affichage
$stmt = $pdo->query("SELECT title, description, image FROM services");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Services du Zoo Arcadia</title>
</head>
<body>
<header>
    <div class="title">
        <img src="../uploads/logozoo.jpg" alt="Logo" class="logo">
        <h1>Services du Zoo Arcadia</h1>
    </div>
</header>
<a class="btn btn-success mt-3" href="../public/menu.php">Retour au menu</a>

<main class="container mt-4">
    <h1>Services du Zoo Arcadia</h1>
    <div class="row">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../uploads/services/<?= htmlspecialchars($service['image']) ?>" class="card-img-top" alt="" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($service['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($service['description']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>&copy; 2024 Zoo Arcadia | <a href="../public/contact.php" class="contact">Nous contacter</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
