<?php
require 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['photo'])) {
    header('Location: dashboard.php');
    exit;
}

$file = $_FILES['photo'];
$category = trim($_POST['category'] ?? '');
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

// Validation des champs texte
if (!array_key_exists($category, CATEGORIES)) {
    header('Location: dashboard.php?error=' . urlencode('Catégorie invalide.'));
    exit;
}
if ($title === '') {
    header('Location: dashboard.php?error=' . urlencode('Le titre est obligatoire.'));
    exit;
}

// Vérifie qu'il n'y a pas eu d'erreur d'upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    header('Location: dashboard.php?error=' . urlencode('Erreur lors de l\'envoi du fichier.'));
    exit;
}

// Vérifie la taille
if ($file['size'] > MAX_FILE_SIZE) {
    header('Location: dashboard.php?error=' . urlencode('Le fichier dépasse 5 Mo.'));
    exit;
}

// Vérifie l'extension
$originalName = $file['name'];
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($ext, ALLOWED_EXTENSIONS)) {
    header('Location: dashboard.php?error=' . urlencode('Format non autorisé. Utilisez JPG, PNG ou WEBP.'));
    exit;
}

// Vérifie que c'est bien une vraie image (pas un fichier renommé)
$imageInfo = getimagesize($file['tmp_name']);
if ($imageInfo === false) {
    header('Location: dashboard.php?error=' . urlencode('Le fichier envoyé n\'est pas une image valide.'));
    exit;
}

// Crée le dossier de destination s'il n'existe pas
if (!is_dir(GALLERY_DIR)) {
    mkdir(GALLERY_DIR, 0755, true);
}

// Génère un nom de fichier unique et sûr (évite les espaces, accents, collisions)
$safeName = uniqid('photo_') . '.' . $ext;
$destination = GALLERY_DIR . $safeName;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    header('Location: dashboard.php?error=' . urlencode('Impossible d\'enregistrer le fichier sur le serveur.'));
    exit;
}

// Enregistre les métadonnées dans le fichier JSON
$photos = loadPhotos();
$photos[] = [
    'id'          => uniqid(),
    'filename'    => $safeName,
    'category'    => $category,
    'title'       => $title,
    'description' => $description,
    'created_at'  => date('c'),
];

if (savePhotos($photos)) {
    header('Location: dashboard.php?uploaded=1');
} else {
    // Le fichier image est bien enregistré mais les métadonnées ont échoué : on prévient
    header('Location: dashboard.php?error=' . urlencode('Photo enregistrée mais les informations n\'ont pas pu être sauvegardées.'));
}
exit;
