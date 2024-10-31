<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../database/db.php';
require_once '../database/auth.php';

if (!isAuthenticated() || !isAdmin()) {
    header('Location: ?page=login');
    exit();
}

// Affichage du message
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Effacer le message après l'affichage
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">

    <?php include "navbar.php"; ?>

    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <h1>Espace Administrateur</h1>
    </header>

    <?php if ($message) : ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <main>
        <h2>Créer un compte utilisateur</h2>
        <form action="?page=users" method="POST">
            <div class="mb-3">
                <input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" required>
            </div>
            <select class="form-select form-select-sm mb-3" name="role" required>
                <option value="">Choisissez le rôle</option>
                <option value="employee">Employé</option>
                <option value="vet">Vétérinaire</option>
            </select>
            <div class="mb-3">
                <input class="form-control" type="password" name="password" placeholder="Mot de passe" required>
            </div>
            <button class="btn btn-success" type="submit">Créer un compte</button>
        </form>
    </main>
</div>
</body>
</html>
