<?php
require '../database/db.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);
        $_SESSION['message'] = "Compte créé avec succès.";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur lors de la création du compte : " . htmlspecialchars($e->getMessage());
    }
    header('Location: ?page=admin'); // Rediriger vers la page d'admin
    exit();
}
?>
