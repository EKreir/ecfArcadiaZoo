<?php
session_start();
require '../database/db.php'; // Connexion à la base de données
require_once '../database/auth.php'; // Authentification

// Vérifier si l'utilisateur est authentifié
if (!isAuthenticated()) {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Récupération des animaux
$stmt = $pdo->query("SELECT * FROM animaux");
$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement de l'enregistrement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $type_nourriture = $_POST['type_nourriture'];
    $quantite = $_POST['quantite'];

    $stmt = $pdo->prepare("INSERT INTO consommation (animal_id, date, heure, type_nourriture, quantite) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$animal_id, $date, $heure, $type_nourriture, $quantite]);

    $_SESSION['success_message'] = "Consommation enregistrée avec succès !";
    header('Location: ' . $_SERVER['PHP_SELF']); // Rediriger vers le même script
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer Consommation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Enregistrer la Consommation d'un Animal</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="animal_id">Sélectionner un Animal :</label>
            <select name="animal_id" id="animal_id" class="form-control" required>
                <option value="">Choisir un animal</option>
                <?php foreach ($animaux as $animal): ?>
                    <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="heure">Heure :</label>
            <input type="time" name="heure" id="heure" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type_nourriture">Type de Nourriture :</label>
            <input type="text" name="type_nourriture" id="type_nourriture" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantite">Quantité (Kg) :</label>
            <input type="number" name="quantite" id="quantite" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <a class="btn btn-secondary mt-3" href="index.php">Retour à l'espace employé</a>
</div>
</body>
</html>
