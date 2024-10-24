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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Espace Administrateur</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="horaires.php">Horaires</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="habitats.php">Habitats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="animaux.php">Animaux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_report.php">Comptes Rendus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger" href="../public/logout.php">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-lg-8 mx-auto p-4 py-md-5">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <h1>Espace Administrateur</h1>
    </header>

    <?php if ($message) : ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
    <?php endif; ?>
    <main>
        <h2>Créer un compte utilisateur</h2>
        <form action="traitement/users.php" method="POST">
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
