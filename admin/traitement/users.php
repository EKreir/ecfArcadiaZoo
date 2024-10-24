<?php
session_start();
require '../../database/db.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $role])) {
        $_SESSION['message'] = "Compte créé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la création du compte.";
    }
    header('Location: ../index.php'); // Rediriger vers la page d'admin
    exit();
}
?>
