<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../../database/db.php';
require_once '../../database/auth.php';

if (!isAuthenticated() || !isAdmin()) {
    header('Location: ../../login.php');
    exit();
}

// Récupérer l'habitat à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$id]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'habitat existe
    if (!$habitat) {
        $_SESSION['message'] = "Habitat non trouvé.";
        header('Location: ../habitats.php');
        exit();
    }
}

// Mise à jour de l'habitat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['habitat_name'];
    $description = $_POST['habitat_description'];

    // Gestion de l'upload de l'image
    $uploads_dir = '../../uploads';

    // Créer le dossier si nécessaire
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }

    // Garder l'ancienne image par défaut
    $image_path = $habitat['image'];

    // Vérifier si une nouvelle image est téléchargée
    if (isset($_FILES['habitat_image']) && $_FILES['habitat_image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['habitat_image']['tmp_name'];
        $name_image = basename($_FILES['habitat_image']['name']);
        $image_path = "$uploads_dir/$name_image";

        // Déplacer le fichier téléchargé vers le dossier cible
        if (!move_uploaded_file($tmp_name, $image_path)) {
            $_SESSION['message'] = "Erreur lors de l'upload de l'image.";
            header('Location: edit_habitat.php?id=' . $id);
            exit(); // Arrêter l'exécution
        }
    }

    // Mettre à jour la base de données
    $stmt = $pdo->prepare("UPDATE habitats SET name = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $image_path, $id]);

    $_SESSION['message'] = "Habitat mis à jour avec succès.";
    header('Location: ../habitats.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Habitat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Modifier Habitat</h2>

    <form action="edit_habitat.php?id=<?= $habitat['id'] ?>" method="POST" enctype="multipart/form-data">
        <input class="form-control mb-3" type="text" name="habitat_name" value="<?= htmlspecialchars($habitat['name']) ?>" required>
        <textarea class="form-control mb-3" name="habitat_description" required><?= htmlspecialchars($habitat['description']) ?></textarea>
        <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="<?= htmlspecialchars($habitat['name']) ?>" style="width: 100px; height: auto;">
        <input type="file" class="form-control mb-3" name="habitat_image" accept="image/*">
        <button class="btn btn-success" type="submit">Mettre à jour Habitat</button>
    </form>
</div>
</body>
</html>
