<?php
// Inclure le fichier de connexion à la base de données
require '../database/db.php';

// Récupération des horaires
$stmt = $pdo->query("SELECT opening_time, closing_time FROM horaires WHERE id = 1");
$horaires = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération des avis validés
$stmt = $pdo->query("SELECT * FROM avis WHERE statut = 'validé'"); // Récupérer uniquement les avis validés
$avis_valides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Zoo Arcadia</title>

</head>
<body>
<header>
    <div class="title">
    <img src="../uploads/logozoo.jpg" alt="Logo" class="logo"">
    <h1>Bienvenue au Zoo Arcadia</h1>
    </div>
    <nav>
        <ul>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="sending.php">Donner son avis</a></li>
        </ul>
    </nav>
</header>

<main class="container mt-4">
    <section id="accueil">
        <h2>Présentation du zoo</h2>
        <p>Arcadia est un zoo situé en France près de la forêt de Brocéliande, en bretagne depuis 1960.
            Ils possèdent tout un panel d’animaux, réparti par habitat (savane, jungle, marais) et font
            extrêmement attention à leurs santés. Chaque jour, plusieurs vétérinaires viennent afin
            d’effectuer les contrôles sur chaque animal avant l’ouverture du zoo afin de s’assurer que tout
            se passe bien, de même, toute la nourriture donnée est calculée afin d’avoir le bon grammage
            (le bon grammage est précisé dans le rapport du vétérinaire).</p>
    </section>

    <div id="imageCarousel" class="carousel slide my-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../uploads/pexels-filip-olsok-261056-4003530.jpg" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="../uploads/pexels-quang-nguyen-vinh-222549-2154706.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="../uploads/pexels-thomas-b-270703-814898.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
                <img src="../uploads/tourist-train-938568_1280.jpg" class="d-block w-100" alt="Image 4">
            </div>
            <div class="carousel-item">
                <img src="../uploads/line-1184810_1280.jpg" class="d-block w-100" alt="Image 5">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>


    <section id="habitats">
        <h2>Habitats</h2>
        <h6>Savane</h6>
        <p>La savane d'Arcadia est un vaste espace ensoleillé, parsemé d'herbes hautes et d'acacias, où les visiteurs peuvent observer des animaux majestueux évoluer dans leur environnement naturel. Ce paysage ouvert, ponctué de points d'eau, offre un habitat idéal pour les espèces qui cohabitent ici.</p>
        <p>Animaux de la savane :</p>
        <p>Lion</p>
        <p>Éléphant d'Afrique</p>
        <p>Girafe</p>
        <p>Zèbre</p>
        <p>Rhinocéros noir</p>
        <h6>Jungle</h6>
        <p>La jungle d'Arcadia est une forêt tropicale dense, riche en biodiversité, où la lumière filtre à travers un feuillage épais. Les sons des oiseaux exotiques et des cris des singes créent une atmosphère vibrante. Cet habitat humide et chaud abrite de nombreuses espèces fascinantes.</p>
        <p>Animaux de la jungle :</p>
        <p>Tigre du Bengale</p>
        <p>Orang-outan</p>
        <p>Paon</p>
        <p>Serpent python</p>
        <p>Singe capucin</p>
        <h6>Marais</h6>
        <p>Le marais d'Arcadia est un écosystème unique, avec des zones d'eau stagnante et des plantes aquatiques luxuriantes. Ce milieu riche en boue et en humidité attire une variété d'animaux qui s'épanouissent dans cette zone humide, offrant aux visiteurs un aperçu fascinant de la vie aquatique et terrestre.</p>
        <p>Animaux du marais :</p>
        <p>Hippopotame</p>
        <p>Crocodile</p>
        <p>Flamant rose</p>
        <p>Grenouille arboricole</p>
        <p>Cygne</p>
    </section>

    <section id="services">
        <h2>Services</h2>
        <h6>Restauration</h6>
        <p>Découvrez une expérience culinaire unique au cœur de notre zoo. Notre espace de restauration propose une variété de plats savoureux, allant des en-cas rapides aux repas complets, préparés avec des ingrédients frais et locaux. Que vous souhaitiez déguster un délicieux burger, une salade fraîche ou un café réconfortant, notre offre saura satisfaire toutes vos envies. Profitez de votre repas en admirant la nature environnante et en partageant des moments conviviaux en famille ou entre amis.</p>
        <h6>Guide Touristique (Gratuit)</h6>
        <p>Explorez notre zoo de manière enrichissante avec notre service de guide touristique gratuit ! Nos guides passionnés vous feront découvrir les secrets et anecdotes fascinants sur nos animaux et leur habitat. Que vous soyez un amoureux des animaux ou simplement curieux, cette visite commentée vous permettra de mieux comprendre notre engagement pour la conservation et l'éducation. Rejoignez-nous à l'heure des visites pour une aventure inoubliable !</p>
        <h6>Train Touristique</h6>
        <p>Montez à bord de notre train touristique pour une exploration relaxante du zoo ! Ce parcours vous emmène à travers nos enclos tout en vous offrant une vue imprenable sur nos magnifiques animaux. Idéal pour les familles ou ceux qui souhaitent se reposer tout en découvrant, le train fait plusieurs arrêts stratégiques pour que vous puissiez explorer à votre rythme. Laissez-vous porter par le charme de notre zoo et profitez d'une expérience mémorable en toute tranquillité.</p>
    </section>

    <section id="horaires">
        <h2>Horaires</h2>
        <?php if ($horaires): ?>
            <p>Du lundi au samedi de <?= htmlspecialchars($horaires['opening_time']) ?> à <?= htmlspecialchars($horaires['closing_time']) ?>.</p>
            <p>Fermé le dimanche</p>
        <?php else: ?>
            <p>Horaires non disponibles.</p>
        <?php endif; ?>
    </section>

    <section id="avis">
        <h2>Avis des Visiteurs</h2>
        <div class="avis-container">
            <?php if (count($avis_valides) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($avis_valides as $avis): ?>
                        <li class="list-group-item">
                            <strong><?= htmlspecialchars($avis['pseudo']) ?>:</strong>
                            <?= htmlspecialchars($avis['contenu']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun avis validé.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>

    <p>&copy; 2024 Zoo Arcadia | <a href="contact.php" class="contact">Nous contacter</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
