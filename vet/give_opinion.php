<?php
session_start();
require '../database/db.php';

// Vérifier si l'utilisateur est authentifié et s'il est vétérinaire
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'vet') {
    header('Location: ../login.php');
    exit();
}

// Récupérer tous les animaux pour le menu déroulant
$stmt = $pdo->query("SELECT * FROM animaux");
$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gérer la soumission du formulaire pour ajouter un avis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_opinion'])) {
    $animal_id = $_POST['animal_id'];
    $etat = $_POST['etat'];
    $nourriture = $_POST['nourriture'];
    $grammage = $_POST['grammage'];
    $date_passage = $_POST['date_passage'];
    $vet_id = $_SESSION['user_id'];

    // Insertion de l'avis dans la base de données
    $stmt = $pdo->prepare("INSERT INTO animal_opinions (animal_id, vet_id, etat, nourriture, grammage, date_passage) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$animal_id, $vet_id, $etat, $nourriture, $grammage, $date_passage]);

    $_SESSION['message'] = "Avis ajouté avec succès.";
    header("Location: give_opinion.php");
    exit();
}

// Gérer la soumission du formulaire pour modifier un avis
if (isset($_POST['edit_opinion'])) {
    $opinion_id = $_POST['opinion_id'];
    $etat = $_POST['etat'];
    $nourriture = $_POST['nourriture'];
    $grammage = $_POST['grammage'];
    $date_passage = $_POST['date_passage'];

    // Mettre à jour l'avis dans la base de données
    $stmt = $pdo->prepare("UPDATE animal_opinions SET etat = ?, nourriture = ?, grammage = ?, date_passage = ? WHERE id = ?");
    $stmt->execute([$etat, $nourriture, $grammage, $date_passage, $opinion_id]);

    $_SESSION['message'] = "Avis modifié avec succès.";
    header("Location: give_opinion.php");
    exit();
}

// Récupérer les avis existants
$stmt = $pdo->prepare("SELECT o.*, u.username FROM animal_opinions o JOIN users u ON o.vet_id = u.id");
$stmt->execute();
$opinions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Donner un Avis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Donner un Avis</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="animal_id" class="form-label">Sélectionnez un Animal</label>
            <select name="animal_id" id="animal_id" class="form-select" required>
                <option value="">Choisir un animal</option>
                <?php foreach ($animaux as $animal): ?>
                    <option value="<?= htmlspecialchars($animal['id']) ?>"><?= htmlspecialchars($animal['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">État de l'Animal</label>
            <input type="text" name="etat" id="etat" class="form-control" placeholder="État de l'animal" required>
        </div>

        <div class="mb-3">
            <label for="nourriture" class="form-label">Nourriture Proposée</label>
            <input type="text" name="nourriture" id="nourriture" class="form-control" placeholder="Type de nourriture" required>
        </div>

        <div class="mb-3">
            <label for="grammage" class="form-label">Grammage (Kg)</label>
            <input type="number" name="grammage" id="grammage" class="form-control" placeholder="Grammage" required min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="date_passage" class="form-label">Date de Passage</label>
            <input type="date" name="date_passage" id="date_passage" class="form-control" required>
        </div>

        <button class="btn btn-success" name="submit_opinion" type="submit">Soumettre l'Avis</button>
        <a class="btn btn-secondary" href="index.php">Retour à l'espace vétérinaire</a>

    </form>

    <h3>Avis des Vétérinaires</h3>
    <ul class="list-group">
        <?php foreach ($opinions as $opinion): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($opinion['username']) ?>:</strong>
                <p>Animal ID: <?= htmlspecialchars($opinion['animal_id']) ?></p>
                <p>État: <?= htmlspecialchars($opinion['etat']) ?></p>
                <p>Nourriture: <?= htmlspecialchars($opinion['nourriture']) ?></p>
                <p>Grammage: <?= htmlspecialchars($opinion['grammage']) ?> Kg</p>
                <p>Date de Passage: <?= htmlspecialchars($opinion['date_passage']) ?></p>

                <!-- Bouton pour modifier l'avis -->
                <button class="btn btn-warning" onclick="editOpinion(<?= $opinion['id'] ?>, '<?= htmlspecialchars($opinion['etat']) ?>', '<?= htmlspecialchars($opinion['nourriture']) ?>', <?= $opinion['grammage'] ?>, '<?= $opinion['date_passage'] ?>')">Modifier</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Formulaire de modification caché -->
    <div id="editOpinionForm" style="display: none;">
        <h4>Modifier l'Avis</h4>
        <form id="formEditOpinion" action="" method="POST">
            <input type="hidden" name="opinion_id" id="opinion_id">
            <div class="mb-3">
                <label for="edit_etat" class="form-label">État de l'Animal</label>
                <input type="text" name="etat" id="edit_etat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="edit_nourriture" class="form-label">Nourriture Proposée</label>
                <input type="text" name="nourriture" id="edit_nourriture" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="edit_grammage" class="form-label">Grammage (Kg)</label>
                <input type="number" name="grammage" id="edit_grammage" class="form-control" required min="0" step="0.01">
            </div>
            <div class="mb-3">
                <label for="edit_date_passage" class="form-label">Date de Passage</label>
                <input type="date" name="date_passage" id="edit_date_passage" class="form-control" required>
            </div>
            <button class="btn btn-primary" name="edit_opinion" type="submit">Modifier l'Avis</button>
        </form>
    </div>
</div>

<script>
    function editOpinion(id, etat, nourriture, grammage, date_passage) {
        document.getElementById('opinion_id').value = id;
        document.getElementById('edit_etat').value = etat;
        document.getElementById('edit_nourriture').value = nourriture;
        document.getElementById('edit_grammage').value = grammage;
        document.getElementById('edit_date_passage').value = date_passage;

        document.getElementById('editOpinionForm').style.display = 'block';
    }
</script>
</body>
</html>
