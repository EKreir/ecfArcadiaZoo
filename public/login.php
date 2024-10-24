<?php
require_once '../database/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        echo "Connexion réussie !<br>";
        echo "Session avant redirection : " . print_r($_SESSION, true) . "<br>";

        if (isAdmin()) {
            header('Location: ../admin/index.php');
            exit();
        } elseif (isEmployee()) {
            header('Location: ../employe/index.php');
            exit();
        } elseif (isVeterinaire()) {
            header('Location: ../vet/index.php');
            exit();
        } else {
            $error = "Vous n'avez pas les droits d'accès à l'espace.";
        }
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
<main class="container mt-4">
    <h1>Connexion</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" required>
        </div>
        <div class="mb-3">
            <input class="form-control" type="password" name="password" placeholder="Mot de passe" required>
        </div>
        <button class="btn btn-primary" type="submit">Se connecter</button>
        <a class="btn btn-secondary" href="index.php">Annuler</a>
    </form>
</main>
</body>
</html>
