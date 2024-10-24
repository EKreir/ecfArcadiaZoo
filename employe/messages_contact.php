<?php
session_start();
require '../database/db.php'; // Connexion à la base de données
require_once '../database/auth.php'; // Authentification

// Vérifier si l'utilisateur est authentifié
if (!isAuthenticated()) {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit();
}

// Traitement des messages de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $messageId = $_POST['message_id'];
        if ($_POST['action'] === 'traiter') {
            // Marquer le message comme traité
            $stmt = $pdo->prepare("UPDATE messages_contact SET statut = 'traité' WHERE id = ?");
            $stmt->execute([$messageId]);
        } elseif ($_POST['action'] === 'repondre') {
            // Enregistrer la réponse
            $reponse = $_POST['reponse'];

            // Récupérer le message correspondant pour obtenir l'email et le titre
            $stmt = $pdo->prepare("SELECT * FROM messages_contact WHERE id = ?");
            $stmt->execute([$messageId]);
            $m = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifiez que le message existe
            if ($m) {
                $stmt = $pdo->prepare("UPDATE messages_contact SET reponse = ? WHERE id = ?");
                $stmt->execute([$reponse, $messageId]);

                // Envoyer l'email à l'utilisateur
                $to = $m['email'];
                $subject = "Réponse à votre message : " . htmlspecialchars($m['titre']);
                $message = "Votre message : " . htmlspecialchars($m['contenu']) . "\n\nRéponse : " . $reponse;
                $headers = "From: noreply@votre-zoo.com"; // Remplace par l'adresse de l'expéditeur

                mail($to, $subject, $message, $headers);

                $_SESSION['success_message'] = "Réponse envoyée avec succès !"; // Message d'alerte
            }
        }
    }
}


// Récupération des messages en attente
$stmt = $pdo->query("SELECT * FROM messages_contact WHERE statut = 'en attente'");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages de Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Messages de Contact</h1>
    <a class="btn btn-secondary mt-3" href="index.php">Retour à l'espace employé</a>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (count($messages) > 0): ?>
        <table class="table">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Email</th>
                <th>Message</th>
                <th>Réponse</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($messages as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['titre']) ?></td>
                    <td><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= htmlspecialchars($m['contenu']) ?></td>
                    <td>
                        <?= $m['reponse'] ? htmlspecialchars($m['reponse']) : 'Pas encore répondu' ?>
                    </td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                            <button type="submit" name="action" value="traiter" class="btn btn-success">Traiter</button>
                        </form>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reponseModal<?= $m['id'] ?>">Répondre</button>
                    </td>
                </tr>

                <!-- Modal pour répondre -->
                <div class="modal fade" id="reponseModal<?= $m['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Répondre à <?= htmlspecialchars($m['email']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                                    <div class="mb-3">
                                        <label for="reponse" class="form-label">Votre Réponse</label>
                                        <textarea class="form-control" id="reponse" name="reponse" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" name="action" value="repondre" class="btn btn-primary">Envoyer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun message soumis.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
