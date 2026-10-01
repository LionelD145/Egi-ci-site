<?php
/**
 * gallery-render.php
 *
 * À inclure dans projects.php, à l'intérieur de la div #galleryGrid,
 * après (ou à la place de) les <article class="gallery-item"> écrits en dur.
 *
 * Génère exactement la même structure HTML que les photos existantes,
 * pour que le filtre par catégorie, le survol et la lightbox du
 * script.js existant fonctionnent sans aucune modification.
 */
require_once __DIR__ . '/public-config.php';

$photos = loadPhotos();

// Les plus récentes en dernier (pour ne pas bouleverser l'ordre visuel
// à chaque nouvel ajout) — inverse cette ligne si tu préfères les
// nouvelles photos en premier.
foreach ($photos as $photo):
    $category    = htmlspecialchars($photo['category']);
    $title       = htmlspecialchars($photo['title']);
    $description = htmlspecialchars($photo['description'] ?: "");
    $tagLabel    = htmlspecialchars(CATEGORIES[$photo['category']] ?? $photo['category']);
    $imgSrc      = 'images/gallery/' . rawurlencode($photo['filename']); // chemin vu depuis projects.php à la racine
    $imgAlt      = htmlspecialchars($photo['title']);
?>
<article class="gallery-item reveal" data-category="<?= $category ?>" data-title="<?= $title ?>" data-description="<?= $description ?>">
    <img loading="lazy" src="<?= $imgSrc ?>" alt="<?= $imgAlt ?>">
    <button class="gallery-open" type="button" aria-label="Agrandir la réalisation">↗</button>
    <div class="gallery-caption">
        <span class="tag"><?= $tagLabel ?></span>
        <h3><?= $title ?></h3>
        <p><?= $description ?></p>
    </div>
</article>
<?php endforeach; ?>
