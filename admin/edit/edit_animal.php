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

// Récupérer l'animal à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM animaux WHERE id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'animal existe
    if (!$animal) {
        $_SESSION['message'] = "Animal non trouvé.";
        header('Location: ../animaux.php');
        exit();
    }
}

// Mise à jour de l'animal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['animal_name'];
    $race = $_POST['animal_race']; // Récupération de la race
    $description = $_POST['animal_description'];
    $habitat_id = $_POST['habitat_id'];

    // Gestion de l'upload de l'image
    $uploads_dir = '../../uploads';
    $image_path = $animal['image']; // Conserver l'ancienne image par défaut

    if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['animal_image']['tmp_name'];
        $name_image = basename($_FILES['animal_image']['name']);
        $image_path = "$uploads_dir/$name_image";

        // Déplacer le fichier téléchargé vers le dossier cible
        if (!move_uploaded_file($tmp_name, $image_path)) {
            $_SESSION['message'] = "Erreur lors de l'upload de l'image.";
            header('Location: edit_animal.php?id=' . $id);
            exit();
        }
    }

    // Mettre à jour la base de données
    $stmt = $pdo->prepare("UPDATE animaux SET name = ?, race = ?, description = ?, image = ?, habitat_id = ? WHERE id = ?");
    $stmt->execute([$name, $race, $description, $image_path, $habitat_id, $id]);

    $_SESSION['message'] = "Animal mis à jour avec succès.";
    header('Location: ../animaux.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Modifier Animal</h2>

    <form action="edit_animal.php?id=<?= $animal['id'] ?>" method="POST" enctype="multipart/form-data">
        <input class="form-control mb-3" type="text" name="animal_name" value="<?= $animal['name'] ?>" required>
        <input class="form-control mb-3" type="text" name="animal_race" value="<?= $animal['race'] ?>" required> <!-- Champ ajouté -->
        <textarea class="form-control mb-3" name="animal_description" required><?= $animal['description'] ?></textarea>

        <?php if ($animal['image']): ?>
            <div class="mb-3">
                <img src="<?= $animal['image'] ?>" alt="<?= $animal['name'] ?>" style="width: 50px; height: auto;">
            </div>
        <?php endif; ?>

        <input type="file" class="form-control mb-3" name="animal_image" accept="image/*">
        <select class="form-select mb-3" name="habitat_id" required>
            <option value="">Choisir un habitat</option>
            <?php
            $habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($habitats as $habitat) : ?>
                <option value="<?= $habitat['id'] ?>" <?= $habitat['id'] == $animal['habitat_id'] ? 'selected' : '' ?>>
                    <?= $habitat['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-success" type="submit">Mettre à jour Animal</button>
    </form>
</div>
</body>
</html>
