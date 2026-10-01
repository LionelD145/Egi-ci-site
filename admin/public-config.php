<?php
// ============================================
// CONFIGURATION PUBLIQUE (aucune session ici)
// Ce fichier peut être inclus depuis n'importe quelle page,
// même après que du HTML a déjà été envoyé (ex: projects.php).
// ============================================

// Dossier où sont stockées les photos (accessible depuis le site public)
define('GALLERY_DIR', __DIR__ . '/../images/gallery/');
define('GALLERY_URL', '../images/gallery/'); // chemin relatif depuis projects.php vers les photos

// Fichier qui stocke les informations de chaque photo (catégorie, titre, description)
define('PHOTOS_JSON', __DIR__ . '/data/photos.json');

// Taille max autorisée par photo (en octets) — ici 5 Mo
define('MAX_FILE_SIZE', 5 * 1024 * 1024);

// Extensions autorisées
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);

// Catégories de la galerie — DOIVENT correspondre exactement aux valeurs
// data-filter utilisées dans projects.html (bouton de filtre par catégorie)
define('CATEGORIES', [
    'construction' => 'Construction',
    'electricite'  => 'Électricité',
    'logistique'   => 'Logistique',
    'telecoms'     => 'Télécoms',
    'equipe'       => 'Equipe',
]);

// ============================================
// Fonctions de lecture/écriture du fichier JSON
// ============================================

function loadPhotos(): array {
    if (!file_exists(PHOTOS_JSON)) {
        return [];
    }
    $content = file_get_contents(PHOTOS_JSON);
    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

function savePhotos(array $photos): bool {
    $dir = dirname(PHOTOS_JSON);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    return file_put_contents(PHOTOS_JSON, json_encode($photos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}
