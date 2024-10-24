<?php
session_start();
require '../../database/db.php';
require_once '../../database/auth.php';

// Vérifier si l'utilisateur est authentifié et s'il est vétérinaire
if (!isAuthenticated() || !isVeterinaire()) {
    header('Location: ../../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Vérifier si un ID de commentaire est passé
if (!isset($_GET['id'])) {
    header('Location: ../comment_habitat.php');
    exit();
}

// Récupérer le commentaire à modifier
$stmt = $pdo->prepare("SELECT * FROM habitat_comments WHERE id = ?");
$stmt->execute([$_GET['id']]);
$comment = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si le commentaire existe
if (!$comment) {
    header('Location: ../comment_habitat.php');
    exit();
}

// Modifier le commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_comment = $_POST['comment'];

    $stmt = $pdo->prepare("UPDATE habitat_comments SET comment = ? WHERE id = ?");
    if ($stmt->execute([$new_comment, $comment['id']])) {
        $_SESSION['message'] = "Commentaire modifié avec succès.";
        header('Location: ../comment_habitat.php');
        exit();
    } else {
        $error = "Erreur lors de la modification du commentaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Commentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Modifier le Commentaire</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="comment" class="form-label">Commentaire</label>
            <textarea name="comment" class="form-control" required><?= htmlspecialchars($comment['comment']) ?></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Modifier</button>
        <a class="btn btn-secondary" href="../comment_habitat.php">Annuler</a>
    </form>
</div>
</body>
</html>
