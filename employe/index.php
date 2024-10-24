<?php
session_start();
require '../database/db.php'; // Connexion à la base de données
require_once '../database/auth.php'; // Authentification

// Vérifier si l'utilisateur est authentifié
if (!isAuthenticated()) {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Traitement des avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $avisId = $_POST['avis_id'];
        if ($_POST['action'] === 'valider') {
            // Valider l'avis
            $stmt = $pdo->prepare("UPDATE avis SET statut = 'validé' WHERE id = ?");
            $stmt->execute([$avisId]);
        } elseif ($_POST['action'] === 'rejeter') {
            // Rejeter l'avis
            $stmt = $pdo->prepare("UPDATE avis SET statut = 'rejeté' WHERE id = ?");
            $stmt->execute([$avisId]);
        }

        $_SESSION['success_message'] = "Avis traité avec succès !"; // Message d'alerte
    }
}

// Récupération des avis en attente
$stmt = $pdo->query("SELECT * FROM avis WHERE statut = 'en attente'");
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Espace Employé</h1>
    <a class="btn btn-primary mt-3" href="modifier_services.php">Modifier les services</a>
    <a class="btn btn-primary mt-3" href="enregistrer_consommation.php"">Consommation animal</a>
    <a class="btn btn-primary mt-3" href="messages_contact.php">Mails reçus</a>
    <a class="btn btn-danger mt-3" href="../public/logout.php">Se déconnecter</a>
    <h2>Avis des Visiteurs</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (count($avis) > 0): ?>
        <table class="table">
            <thead>
            <tr>
                <th>Pseudo</th>
                <th>Avis</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($avis as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['pseudo']) ?></td>
                    <td><?= htmlspecialchars($a['contenu']) ?></td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="avis_id" value="<?= $a['id'] ?>">
                            <button type="submit" name="action" value="valider" class="btn btn-success">Valider</button>
                            <button type="submit" name="action" value="rejeter" class="btn btn-danger">Rejeter</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun avis soumis.</p>
    <?php endif; ?>

</div>
</body>
</html>
