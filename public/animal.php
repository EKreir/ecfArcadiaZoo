<?php
require '../database/db.php';
require '../database/client.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Incrémentation des consultations dans MongoDB
    $collection = $client->animal_db->animal_views;
    $animalView = $collection->findOne(['animal_id' => $id]);

    if ($animalView) {
        // Si l'animal existe déjà, on augmente le compteur
        $collection->updateOne(
            ['animal_id' => $id],
            ['$inc' => ['consultations' => 1]]
        );
    } else {
        // Si l'animal n'existe pas, on l'ajoute avec 1 consultation
        $collection->insertOne([
            'animal_id' => $id,
            'consultations' => 1
        ]);
    }

    // Récupérer l'animal
    $stmt = $pdo->prepare("SELECT * FROM animaux WHERE id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        die("Animal non trouvé.");
    }

    // Récupérer l'habitat de l'animal
    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$animal['habitat_id']]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer les avis sur l'animal
    $stmt = $pdo->prepare("SELECT etat, nourriture, grammage, date_passage FROM animal_opinions WHERE animal_id = ?");
    $stmt->execute([$id]);
    $opinions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$habitat) {
        die("Habitat non trouvé.");
    }
} else {
    die("Aucun ID fourni.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($animal['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .img-fluid {
            width: 75%;
            border-radius: 5px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
<main class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($animal['name']) ?></h2>
            <img src="<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" class="img-fluid mb-3">
            <h4 class="card-subtitle mb-2 text-muted">Race : <?= htmlspecialchars($animal['race']) ?></h4>
            <h4 class="card-subtitle mb-2 text-muted">Affectation de l'habitat : <?= htmlspecialchars($habitat['name']) ?></h4>
            <h3>Détails de l'Avis des Vétérinaires : </h3>
            <?php if (count($opinions) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($opinions as $opinion): ?>
                        <li class="list-group-item">
                            <p>État de l'animal: <?= htmlspecialchars($opinion['etat']) ?></p>
                            <p>Nourriture proposée: <?= htmlspecialchars($opinion['nourriture']) ?></p>
                            <p>Grammage de la nourriture: <?= htmlspecialchars($opinion['grammage']) ?> Kg</p>
                            <p>Date de passage: <?= htmlspecialchars($opinion['date_passage']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun avis disponible pour cet animal.</p>
            <?php endif; ?>

            <a href="habitat.php?id=<?= $animal['habitat_id'] ?>" class="btn btn-primary">Retour à l'Habitat</a>
        </div>
    </div>

</main>
</body>
</html>