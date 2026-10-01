<?php
require_once __DIR__ . '/public-config.php';

session_start();

// ============================================
// CONFIGURATION ADMIN - à personnaliser
// ============================================

// Identifiant de connexion admin
define('ADMIN_USERNAME', 'admin');

// Mot de passe : ne JAMAIS écrire le mot de passe en clair ici.
// Génère le hash avec la commande PHP suivante (une seule fois, en local) :
//   php -r "echo password_hash('TonMotDePasse', PASSWORD_DEFAULT);"
// Puis colle le résultat ci-dessous.
define('ADMIN_PASSWORD_HASH', '$2y$10$oN.2ummXzWFoDL0C8MDInernepJKc5BZoF0VusiYO1q2hs2GwYzIi');

// ============================================
// Fonctions utilitaires
// ============================================

function isLoggedIn(): bool {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}
