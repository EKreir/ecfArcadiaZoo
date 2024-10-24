<?php
// Inclure le fichier de connexion à la base de données
require '../database/db.php';

session_start();

$message = ''; // Initialiser le message de succès

try {
    // Traitement du formulaire d'envoi d'avis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pseudo = $_POST['pseudo'];
        $contenu = $_POST['contenu'];

        // Préparation et exécution de la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO avis (pseudo, contenu, date_publication, statut) VALUES (:pseudo, :contenu, NOW(), 'en attente')");
        $stmt->execute(['pseudo' => $pseudo, 'contenu' => $contenu]);

        $message = "Votre avis a été soumis avec succès !"; // Message de succès
    }
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Soumettre un Avis</title>
</head>
<body>
<header>
    <div class="title">
        <img src="../uploads/logozoo.jpg" alt="Logo" class="logo">
        <h1>Soumettre un avis</h1>
    </div>
</header>

<main class="container mt-5">
    <?php if ($message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <section>
        <h2 class="mt-5">Soumettre un avis</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="pseudo">Pseudo:</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="contenu">Avis:</label>
                <textarea class="form-control" id="contenu" name="contenu" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Envoyer l'avis</button>
        </form>

        <a class="btn btn-primary mt-3" href="index.php">Retour à l'accueil</a>
    </section>
</main>

<footer>
    <p>&copy; 2024 Zoo Arcadia | <a href="contact.php" class="contact">Nous contacter</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>