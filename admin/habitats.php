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

$habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);

// Ajouter un habitat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habitat_name'])) {
$name = $_POST['habitat_name'];
$description = $_POST['habitat_description'];
$image_path = null; // Initialisation de la variable

// Gestion de l'upload de l'image
$uploads_dir = '../uploads';

// Créer le dossier si nécessaire
if (!is_dir($uploads_dir)) {
mkdir($uploads_dir, 0755, true);
}

if (isset($_FILES['habitat_image']) && $_FILES['habitat_image']['error'] === UPLOAD_ERR_OK) {
$tmp_name = $_FILES['habitat_image']['tmp_name'];
$name_image = basename($_FILES['habitat_image']['name']);
$image_path = "$uploads_dir/$name_image";

// Déplacer le fichier téléchargé vers le dossier cible
if (move_uploaded_file($tmp_name, $image_path)) {
// L'image a été déplacée avec succès, on peut insérer dans la base de données
} else {
$_SESSION['message'] = "Erreur lors de l'upload de l'image.";
header('Location: habitats.php');
exit(); // Arrêter l'exécution pour éviter des erreurs supplémentaires
}
} else {
$_SESSION['message'] = "Aucune image téléchargée.";
header('Location: habitats.php');
exit(); // Arrêter l'exécution si aucune image n'est fournie
}

// Insertion dans la base de données
if ($image_path) { // S'assurer qu'il y a une image valide
$stmt = $pdo->prepare("INSERT INTO habitats (name, description, image) VALUES (?, ?, ?)");
$stmt->execute([$name, $description, $image_path]);
} else {
$_SESSION['message'] = "Erreur lors de l'ajout de l'habitat.";
header('Location: habitats.php');
exit();
}

$_SESSION['message'] = "Habitat ajouté avec succès.";
header('Location: habitats.php'); // Redirection après l'ajout réussi
exit();
}

// Suppression d'un habitat
if (isset($_GET['delete'])) {
$id = $_GET['delete'];
$stmt = $pdo->prepare("DELETE FROM habitats WHERE id = ?");
$stmt->execute([$id]);
$_SESSION['message'] = "Habitat supprimé avec succès.";
header('Location: habitats.php');
exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Habitats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include 'navbar.php'; ?>
    <h2>Gestion des Habitats</h2>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="habitats.php" method="POST" enctype="multipart/form-data">
        <input class="form-control mb-3" type="text" name="habitat_name" placeholder="Nom de l'habitat" required>
        <textarea class="form-control mb-3" name="habitat_description" placeholder="Description de l'habitat" required></textarea>
        <input type="file" class="form-control mb-3" name="habitat_image" accept="image/*" required>
        <button class="btn btn-success" type="submit">Ajouter Habitat</button>
    </form>

    <h3>Liste des Habitats</h3>
    <ul class="list-group">
        <?php foreach ($habitats as $habitat) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= $habitat['name'] ?>
                <div>
                    <?php if ($habitat['image']): ?>
                        <img src="<?= $habitat['image'] ?>" alt="<?= $habitat['name'] ?>" style="width: 100px; height: auto;">
                    <?php endif; ?>
                    <a href="edit/edit_habitat.php?id=<?= $habitat['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="?delete=<?= $habitat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitat ?')">Supprimer</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
