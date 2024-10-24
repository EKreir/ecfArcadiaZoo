<?php
// Inclure le fichier de connexion à la base de données
require '../database/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Assurez-vous que PHPMailer est chargé

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $email = $_POST['email'];

    // Préparez votre requête pour insérer le message dans la base de données
    $stmt = $pdo->prepare("INSERT INTO messages_contact (titre, contenu, email, statut) VALUES (?, ?, ?, 'en attente')");
    $stmt->execute([$title, $description, $email]);

    // Envoyer l'email
    $mail = new PHPMailer(true);
    try {
        // Paramétrage du serveur
        $mail->isSMTP();
        $mail->Host = '127.0.0.1'; // ou 'localhost'
        $mail->Port = 1025; // Port par défaut de Mailpit
        $mail->SMTPAuth = false; // Pas d'authentification

        // Destinataire
        $mail->setFrom('noreply@votre-zoo.com', 'Zoo Arcadia');
        $mail->addAddress($email);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Merci de nous avoir contactés!';
        $mail->Body = "Votre message a été reçu avec succès : <strong>$description</strong>";

        $mail->send();
        $success_message = "Votre message a été envoyé avec succès!";
    } catch (Exception $e) {
        $error_message = "Erreur d'envoi : {$mail->ErrorInfo}";
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Nous Contacter</title>
</head>
<body>
<header>
    <div class="title">
        <img src="../uploads/logozoo.jpg" alt="Logo" class="logo">
        <h1>Nous contacter</h1>
    </div>
</header>

<a class="btn btn-success" href="index.php">Retour</a>

<main class="container mt-5">
    <section>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-success">Envoyer</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2024 Zoo Arcadia </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
