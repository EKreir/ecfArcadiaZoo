<?php
require_once '../database/auth.php';
logout(); // Appelle la fonction de déconnexion
header('Location: ?page=login'); // Redirige vers la page de connexion
exit();
?>
