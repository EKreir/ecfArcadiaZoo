<?php
session_start();

require_once '../database/auth.php';

$page = 'home'; // Page par défaut

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

// Définir les pages autorisées pour le frontend
$frontend_pages = ['home', 'menu', 'contact', 'sending', 'service', 'animal', 'habitat', 'login', 'logout'];

// Définir les pages autorisées pour l'admin
$admin_pages = ['admin', 'horaires', 'habitats', 'animaux', 'services', 'view_report',
    'dashboard', 'users', 'manage_habitats', 'manage_animals', 'edit_habitat', 'edit_animal'];

// Définir les pages autorisées pour les employés
$employe_pages = ['employe', 'enregistrer_consommation',
    'messages_contact', 'modifier_services'];

// Définir les pages autorisées pour les vétérinaires
$vet_pages = ['vet', 'give_opinion', 'create_report',
    'comment_habitat', 'edit_comment'];

if (in_array($page, $frontend_pages)) {
    require "../frontend/{$page}.php"; // Charge les pages du frontend
} elseif (in_array($page, $admin_pages)) {
    // Vérifier si la page admin est demandée
    if ($page === 'admin') {
        if (isAuthenticated() && isAdmin()) {
            require "../admin/admin.php"; // Charge la page admin
        } else {
            header('Location: ../frontend/login.php');
            exit();
        }
    } else {
        require "../admin/{$page}.php"; // Charge les pages de l'admin
    }
} elseif (in_array($page, $employe_pages)) {
    // Charger les pages de l'employé
    if (isAuthenticated() && isEmployee()) {
        require "../employe/{$page}.php"; // Charge les pages des employés
    } else {
        header('Location: ../frontend/login.php');
        exit();
    }
} elseif (in_array($page, $vet_pages)) {
    // Charger les pages du vétérinaire
    if (isAuthenticated() && isVeterinaire()) {
        require "../vet/{$page}.php"; // Charge les pages des vétérinaires
    } else {
        header('Location: ../frontend/login.php');
        exit();
    }
}
else {
    echo "error"; // Page non trouvée
}