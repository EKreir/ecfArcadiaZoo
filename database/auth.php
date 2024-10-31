<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

function login($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
    }

    return false;
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isEmployee() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'employee';
}

function isVeterinaire() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'vet';
}

function isAuthenticated() {
    return isset($_SESSION['username']);
}

function logout() {
    session_unset();
    session_destroy();
}