<?php
require 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    header('Location: dashboard.php');
    exit;
}

$id = $_POST['id'];
$photos = loadPhotos();

$found = null;
$remaining = [];
foreach ($photos as $photo) {
    if ($photo['id'] === $id) {
        $found = $photo;
    } else {
        $remaining[] = $photo;
    }
}

if ($found === null) {
    header('Location: dashboard.php?error=' . urlencode('Photo introuvable.'));
    exit;
}

// Supprime le fichier image du dossier
$filepath = GALLERY_DIR . basename($found['filename']);
if (file_exists($filepath)) {
    unlink($filepath);
}

// Met à jour le JSON sans cette entrée
savePhotos($remaining);

header('Location: dashboard.php?deleted=1');
exit;
