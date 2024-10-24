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

// Récupération des horaires
$horaires = $pdo->query("SELECT * FROM horaires")->fetchAll(PDO::FETCH_ASSOC);
$horairesExistants = count($horaires) > 0;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opening_time = $_POST['opening_time'];
    $closing_time = $_POST['closing_time'];

    if ($horairesExistants) {
        // Mise à jour des horaires existants
        $stmt = $pdo->prepare("UPDATE horaires SET opening_time = ?, closing_time = ? WHERE id = 1");
        $stmt->execute([$opening_time, $closing_time]);
        $_SESSION['message'] = "Horaires mis à jour avec succès.";
    } else {
        // Création des horaires
        $stmt = $pdo->prepare("INSERT INTO horaires (opening_time, closing_time) VALUES (?, ?)");
        $stmt->execute([$opening_time, $closing_time]);
        $_SESSION['message'] = "Horaires créés avec succès.";
    }
    header('Location: horaires.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Horaires</title>
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

    <h2><?= $horairesExistants ? 'Modifier les Horaires' : 'Ajouter les Horaires' ?></h2>
    <form action="horaires.php" method="POST">
        <div class="mb-3">
            <input class="form-control" type="time" name="opening_time" value="<?= $horairesExistants ? $horaires[0]['opening_time'] : '' ?>" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="time" name="closing_time" value="<?= $horairesExistants ? $horaires[0]['closing_time'] : '' ?>" required>
        </div>
        <button class="btn btn-primary" type="submit"><?= $horairesExistants ? 'Mettre à jour les horaires' : 'Créer les horaires' ?></button>
    </form>
</div>
</body>
</html>
