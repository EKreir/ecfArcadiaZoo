<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../database/db.php';
require_once '../database/auth.php';

if (!isAuthenticated() || !isAdmin()) {
    header('Location: ../login.php');
    exit();
}

$animaux = $pdo->query("SELECT * FROM animaux")->fetchAll(PDO::FETCH_ASSOC);
$habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include 'navbar.php'; ?>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h2>Gestion des Animaux</h2>
    <form action="traitement/manage_animals.php" method="POST" enctype="multipart/form-data">
        <input class="form-control mb-3" type="text" name="animal_name" placeholder="Nom de l'animal" required>
        <input class="form-control mb-3" type="text" name="animal_race" placeholder="Race de l'animal" required> <!-- Champ ajouté -->
        <textarea class="form-control mb-3" name="animal_description" placeholder="Description de l'animal" required></textarea>
        <input type="file" class="form-control mb-3" name="animal_image" accept="image/*" required>
        <select class="form-select mb-3" name="habitat_id" required>
            <option value="">Choisir un habitat</option>
            <?php foreach ($habitats as $habitat) : ?>
                <option value="<?= $habitat['id'] ?>"><?= $habitat['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-success" type="submit">Ajouter Animal</button>
    </form>

    <h3>Liste des Animaux</h3>
    <ul class="list-group">
        <?php foreach ($animaux as $animal) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="me-3">
                    <?php if ($animal['image']): ?>
                        <img src="<?= $animal['image'] ?>" alt="<?= $animal['name'] ?>" style="width: 100px;">
                    <?php endif; ?>
                </div>
                <?= $animal['name'] ?>
                <div>
                    <a href="edit/edit_animal.php?id=<?= $animal['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="traitement/manage_animals.php?delete=<?= $animal['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?')">Supprimer</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

</div>
</body>
</html>