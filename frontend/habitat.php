<?php
require '../database/db.php';

// Récupération des habitats
$habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);

// Récupération des animaux associés à chaque habitat
$animaux = $pdo->query("SELECT * FROM animaux")->fetchAll(PDO::FETCH_ASSOC);

// Organiser les animaux par habitat
$animaux_par_habitat = [];
foreach ($animaux as $animal) {
    $animaux_par_habitat[$animal['habitat_id']][] = $animal;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Habitats du Zoo Arcadia</title>
</head>
<body>
<header>
    <div class="title">
        <img src="../uploads/logozoo.jpg" alt="Logo" class="logo">
        <h1>Habitats du Zoo Arcadia</h1>
    </div>
</header>
<a class="btn btn-success mt-3" href="../public/menu.php">Retour au menu</a>

<main class="container mt-4">
    <section id="habitats">
        <h2>Nos Habitats</h2>
        <div class="row">
            <?php foreach ($habitats as $habitat): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="<?= htmlspecialchars($habitat['name']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($habitat['name']) ?></h5>
                            <button class="btn btn-info" data-bs-toggle="collapse" data-bs-target="#desc-<?= $habitat['id'] ?>">Voir Description</button>
                            <div class="collapse" id="desc-<?= $habitat['id'] ?>">
                                <p class="card-text"><?= htmlspecialchars($habitat['description']) ?></p>
                                <h6>Animaux associés :</h6>
                                <ul>
                                    <?php if (isset($animaux_par_habitat[$habitat['id']])): ?>
                                        <?php foreach ($animaux_par_habitat[$habitat['id']] as $animal): ?>
                                            <li>
                                                <a href="animal.php?id=<?= $animal['id'] ?>" class="text-decoration-none">
                                                    <?= htmlspecialchars($animal['name']) ?> - <?= htmlspecialchars($animal['race']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>Aucun animal associé.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2024 Zoo Arcadia | <a href="../public/contact.php" class="contact">Nous contacter</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
