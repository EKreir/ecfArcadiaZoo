<?php
session_start();
require '../database/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est authentifié et s'il est vétérinaire
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'vet') {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Récupérer les animaux pour le sélecteur
$stmt = $pdo->query("SELECT * FROM animaux");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialiser les messages
$message = '';
$error = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'];
    $report_text = $_POST['report_text'];
    $vet_id = $_SESSION['user_id']; // L'ID de l'utilisateur connecté

    // Insérer le compte rendu dans la base de données
    $stmt = $pdo->prepare("INSERT INTO reports (animal_id, vet_id, report_text, created_at) VALUES (?, ?, ?, NOW())");

    if ($stmt->execute([$animal_id, $vet_id, $report_text])) {
        $message = "Compte rendu envoyé avec succès.";
    } else {
        $error = "Erreur lors de l'envoi du compte rendu. Veuillez réessayer.";
        error_log("Erreur lors de l'insertion du compte rendu : " . implode(",", $stmt->errorInfo())); // Log de l'erreur
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Compte Rendu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Créer un Compte Rendu</h1>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="animal_id" class="form-label">Animal :</label>
            <select name="animal_id" class="form-select" required>
                <?php foreach ($animals as $animal): ?>
                    <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="report_text" class="form-label">Compte Rendu :</label>
            <textarea name="report_text" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
        <a class="btn btn-secondary" href="index.php">Retour à l'espace vétérinaire</a>
    </form>
</div>
</body>
</html>
