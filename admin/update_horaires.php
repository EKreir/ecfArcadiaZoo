<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../database/db.php';

if (!isAuthenticated() || !isAdmin()) {
    header('Location: ?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opening_time = $_POST['opening_time'];
    $closing_time = $_POST['closing_time'];

    $stmt = $pdo->prepare("UPDATE horaires SET opening_time = ?, closing_time = ? WHERE id = 1");
    $stmt->execute([$opening_time, $closing_time]);

    session_start();
    $_SESSION['message'] = "Horaires mis à jour avec succès.";
    header('Location: ?page=horaires');
}
?>
