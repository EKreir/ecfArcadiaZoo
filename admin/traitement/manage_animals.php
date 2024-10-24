<?php
session_start();
require '../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['animal_name'];
    $race = $_POST['animal_race']; // Récupération de la race
    $description = $_POST['animal_description'];
    $habitat_id = $_POST['habitat_id'];

    // Gestion de l'upload de l'image
    $uploads_dir = '../../uploads'; // Chemin vers le dossier de destination

    // Créer le dossier si nécessaire
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }

    // Vérification de l'image
    $image_path = null; // Initialisation de la variable
    if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['animal_image']['tmp_name'];
        $name_image = basename($_FILES['animal_image']['name']);
        $image_path = "$uploads_dir/$name_image";

        // Déplacer le fichier téléchargé vers le dossier cible
        if (move_uploaded_file($tmp_name, $image_path)) {
            // L'image a été déplacée avec succès
        } else {
            $_SESSION['message'] = "Erreur lors de l'upload de l'image.";
            header('Location: ../animaux.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "Aucune image téléchargée.";
        header('Location: ../animaux.php');
        exit();
    }

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO animaux (name, race, description, image, habitat_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $race, $description, $image_path, $habitat_id]);

    $_SESSION['message'] = "Animal ajouté avec succès.";
    header('Location: ../animaux.php'); // Redirection vers la page des animaux
    exit();
}

// Suppression d'un animal
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM animaux WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['message'] = "Animal supprimé avec succès.";
    header('Location: ../animaux.php'); // Redirection vers la page des animaux
    exit();
}

?>
