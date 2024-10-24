<?php
session_start();
require '../database/db.php'; // Connexion à la base de données
require_once '../database/auth.php'; // Authentification

// Vérifier si l'utilisateur est authentifié
if (!isAuthenticated()) {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Récupération des services
$stmt = $pdo->query("SELECT * FROM services");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement des modifications
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['services'] as $id => $data) {
        $title = $data['title'];
        $description = $data['description'];

        // Gestion de l'image
        $image = $data['existing_image']; // Par défaut, on garde l'image existante
        if (isset($_FILES['services']['name'][$id]['image']) && $_FILES['services']['name'][$id]['image'] != '') {
            // Vérification si un fichier a été téléchargé
            $target_dir = "../uploads/"; // Assurez-vous que ce dossier existe
            $image = basename($_FILES['services']['name'][$id]['image']);
            $target_file = $target_dir . $image;

            // Déplacement du fichier téléchargé
            if (move_uploaded_file($_FILES['services']['tmp_name'][$id]['image'], $target_file)) {
                // Si le téléchargement est réussi, on garde le nouveau nom de fichier
            } else {
                // Gérer l'erreur de téléchargement si nécessaire
                $_SESSION['error_message'] = "Erreur lors du téléchargement de l'image.";
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        }

        // Mettre à jour la base de données
        $stmt = $pdo->prepare("UPDATE services SET title = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$title, $description, $image, $id]);
    }
    $_SESSION['success_message'] = "Services modifiés avec succès !";
    header('Location: ' . $_SERVER['PHP_SELF']); // Rediriger vers le même script
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Modifier les Services</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($_SESSION['error_message']); ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Image</th>
                <th>Aperçu</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= htmlspecialchars($service['id']) ?></td>
                    <td>
                        <input type="text" name="services[<?= $service['id'] ?>][title]" value="<?= htmlspecialchars($service['title']) ?>" class="form-control" required>
                    </td>
                    <td>
                        <textarea name="services[<?= $service['id'] ?>][description]" class="form-control" required><?= htmlspecialchars($service['description']) ?></textarea>
                    </td>
                    <td>
                        <input type="file" name="services[<?= $service['id'] ?>][image]" class="form-control">
                        <input type="hidden" name="services[<?= $service['id'] ?>][existing_image]" value="<?= htmlspecialchars($service['image']) ?>">
                    </td>
                    <td>
                        <?php if ($service['image']): ?>
                            <img src="../uploads/<?= htmlspecialchars($service['image']) ?>" alt="Image de service" style="width: 100px;">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
    </form>

    <a class="btn btn-secondary mt-3" href="index.php">Retour à l'espace employé</a>
</div>
</body>
</html>
