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

// Traitement des formulaires pour ajouter un service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_path = null;

    // Gestion de l'upload de l'image
    $uploads_dir = '../uploads/services';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $name_image = basename($_FILES['image']['name']);
        $image_path = "$uploads_dir/$name_image";

        if (!move_uploaded_file($tmp_name, $image_path)) {
            $_SESSION['message'] = "Erreur lors de l'upload de l'image.";
            header('Location: services.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "Aucune image téléchargée.";
        header('Location: services.php');
        exit();
    }

    // Ajout d'un nouveau service
    $stmt = $pdo->prepare("INSERT INTO services (title, description, image) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $image_path]);
    $_SESSION['message'] = "Service ajouté avec succès.";
    header('Location: services.php');
    exit();
}

// Suppression d'un service
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = "Service supprimé avec succès.";
    header('Location: services.php');
    exit();
}

// Récupération des services pour affichage
$stmt = $pdo->query("SELECT * FROM services");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include 'navbar.php' ?>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h2>Administration des Services</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="">
        <div class="mb-3">
            <label class="form-label" for="title">Titre :</label>
            <input class="form-control" type="text" name="title" required>
            <label class="form-label" for="description">Description :</label>
            <textarea class="form-control" name="description" required></textarea>
            <label class="form-label" for="image">Image :</label>
            <input type="file" class="form-control" name="image" accept="image/*" required>
            <button class="btn btn-success mt-2" type="submit">Enregistrer</button>
        </div>
    </form>

    <h2>Services existants</h2>
    <ul class="list-group">
        <?php foreach ($services as $service): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong><?php echo htmlspecialchars($service['title']); ?></strong><br>
                    <img src="<?= $service['image'] ?>" alt="<?= htmlspecialchars($service['title']) ?>" style="width: 100px; height: auto;">
                </div>
                <div>
                    <a href="?delete=<?= $service['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">Supprimer</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

</div>
</body>
</html>
