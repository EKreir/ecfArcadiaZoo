<?php
session_start();
require '../database/db.php';
require_once '../database/auth.php';

// Vérifier si l'utilisateur est authentifié et s'il est vétérinaire
if (!isAuthenticated() || !isVeterinaire()) {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Récupérer tous les habitats
$habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);

// Ajouter un commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habitat_id'], $_POST['comment'])) {
    $habitat_id = $_POST['habitat_id'];
    $comment = $_POST['comment'];
    $vet_id = $_SESSION['user_id']; // ID de l'utilisateur vétérinaire

    $stmt = $pdo->prepare("INSERT INTO habitat_comments (habitat_id, vet_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$habitat_id, $vet_id, $comment]);

    $_SESSION['message'] = "Commentaire ajouté avec succès.";
    header('Location: comment_habitat.php'); // Redirection après l'ajout réussi
    exit();
}

// Récupérer les commentaires des habitats
$comments = $pdo->query("SELECT hc.*, h.name AS habitat_name, u.username AS vet_name 
                          FROM habitat_comments hc 
                          JOIN habitats h ON hc.habitat_id = h.id 
                          JOIN users u ON hc.vet_id = u.id")->fetchAll(PDO::FETCH_ASSOC);

// Supprimer un commentaire
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM habitat_comments WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    $_SESSION['message'] = "Commentaire supprimé avec succès.";
    header('Location: comment_habitat.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commenter les Habitats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Commenter les Habitats</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="comment_habitat.php" method="POST">
        <div class="mb-3">
            <label for="habitat_id" class="form-label">Sélectionner un Habitat</label>
            <select name="habitat_id" class="form-select" required>
                <option value="">Choisir un habitat</option>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= $habitat['id'] ?>"><?= htmlspecialchars($habitat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Commentaire</label>
            <textarea name="comment" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Ajouter Commentaire</button>
        <a class="btn btn-secondary" href="index.php">Retour à l'espace vétérinaire</a>
    </form>

    <h3>Commentaires des Habitats</h3>
    <ul class="list-group">
        <?php foreach ($comments as $comment): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($comment['habitat_name']) ?></strong> - Commenté par <?= htmlspecialchars($comment['vet_name']) ?> le <?= htmlspecialchars($comment['created_at']) ?>
                <p><?= htmlspecialchars($comment['comment']) ?></p>
                <a href="traitement/edit_comment.php?id=<?= $comment['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                <a href="?delete_id=<?= $comment['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
