<?php
require '../database/auth.php';
logout(); // Appelle la fonction de déconnexion
header('Location: login.php'); // Redirige vers la page de connexion
exit();
?>
