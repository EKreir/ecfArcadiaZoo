<?php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Menu - Zoo Arcadia</title>
    <style>
    .img-fluid {
        width: 75%;
        border-radius: 5px;
    }
    h2 {
        text-align: center;
    }
    </style>
</head>
<body>
<header>
    <div class="title">
        <img src="uploads/logozoo.jpg" alt="Logo" class="logo">
        <h1>Menu du Zoo Arcadia</h1>
    </div>
    <nav>
        <ul>
            <li><a href="?page=home">Retour à la page d'accueil</a></li>
            <br>
            <li><a href="?page=sending">Donner son avis</a></li>
        </ul>
    </nav>
</header>

<main class="container mt-5">
    <section>
        <h2>Menu des Services et Habitats</h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <h3>Services</h3>
                <img src="uploads/pexels-reneasmussen-1581384.jpg" alt="Services" class="img-fluid mb-3">
                <p>Découvrez nos services variés pour améliorer votre expérience au zoo.</p>
                <a class="btn btn-success" href="?page=service">Voir les services</a>
            </div>

            <div class="col-md-6 mb-4">
                <h3>Habitats</h3>
                <img src="uploads/pexels-rifkyilhamrd-788200.jpg" alt="Habitats" class="img-fluid mb-3">
                <p>Explorez les différents habitats de nos animaux.</p>
                <a class="btn btn-success" href="?page=habitat">Voir les habitats</a>
            </div>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2024 Zoo Arcadia | <a href="?page=contact" class="contact">Nous contacter</a> | <a href="?page=login" class="contact">Connexion</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>