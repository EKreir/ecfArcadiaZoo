<?php
session_start();
require '../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['habitat_name'];
    $description = $_POST['habitat_description'];

    $stmt = $pdo->prepare("INSERT INTO habitats (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $description]);

    session_start();
    $_SESSION['message'] = "Habitat ajouté avec succès.";
    header('Location: index.php');
}