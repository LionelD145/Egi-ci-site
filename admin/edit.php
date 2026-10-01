<?php
require 'config.php';
requireLogin();

$id = $_GET['id'] ?? $_POST['id'] ?? '';
$photos = loadPhotos();

$current = null;
foreach ($photos as $photo) {
    if ($photo['id'] === $id) {
        $current = $photo;
        break;
    }
}

if ($current === null) {
    header('Location: dashboard.php?error=' . urlencode('Photo introuvable.'));
    exit;
}

$errorMsg = '';

// ============================================
// Traitement du formulaire (enregistrement)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!array_key_exists($category, CATEGORIES)) {
        $errorMsg = 'Catégorie invalide.';
    } elseif ($title === '') {
        $errorMsg = 'Le titre est obligatoire.';
    } else {
        $newFilename = $current['filename']; // par défaut, on garde l'ancienne photo

        // Si un nouveau fichier a été envoyé, on le traite
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['photo'];

            if ($file['size'] > MAX_FILE_SIZE) {
                $errorMsg = 'Le fichier dépasse 5 Mo.';
            } else {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ALLOWED_EXTENSIONS)) {
                    $errorMsg = 'Format non autorisé. Utilisez JPG, PNG ou WEBP.';
                } elseif (getimagesize($file['tmp_name']) === false) {
                    $errorMsg = 'Le fichier envoyé n\'est pas une image valide.';
                } else {
                    $newFilename = uniqid('photo_') . '.' . $ext;
                    $destination = GALLERY_DIR . $newFilename;

                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        // Supprime l'ancienne photo devenue inutile
                        $oldPath = GALLERY_DIR . $current['filename'];
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    } else {
                        $errorMsg = 'Impossible d\'enregistrer la nouvelle photo.';
                        $newFilename = $current['filename']; // on annule le changement
                    }
                }
            }
        }

        // Si tout est valide, on enregistre les modifications
        if ($errorMsg === '') {
            foreach ($photos as &$photo) {
                if ($photo['id'] === $id) {
                    $photo['title'] = $title;
                    $photo['category'] = $category;
                    $photo['description'] = $description;
                    $photo['filename'] = $newFilename;
                }
            }
            unset($photo);

            if (savePhotos($photos)) {
                header('Location: dashboard.php?updated=1');
                exit;
            } else {
                $errorMsg = 'Impossible d\'enregistrer les modifications.';
            }
        }
    }

    // En cas d'erreur, on garde les valeurs saisies pour ne pas les perdre
    $current['title'] = $title;
    $current['category'] = $category;
    $current['description'] = $description;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifier la photo — Administration EGI-CI</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #f4f5f7;
    color: #1a1f27;
  }
  header {
    background: #14275F;
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  header h1 { font-size: 1.1rem; }
  header a {
    color: #fff;
    text-decoration: none;
    font-size: .82rem;
    border: 1px solid rgba(255,255,255,.3);
    padding: 7px 14px;
    border-radius: 6px;
    transition: .2s;
  }
  header a:hover { background: rgba(255,255,255,.1); }

  main {
    max-width: 640px;
    margin: 0 auto;
    padding: 32px 20px 60px;
  }

  .msg {
    padding: 12px 16px;
    border-radius: 6px;
    font-size: .85rem;
    margin-bottom: 24px;
  }
  .msg.error { background: #fdecea; color: #c0392b; }

  .edit-card {
    background: #fff;
    border: 1px solid #e2e5e9;
    border-radius: 10px;
    padding: 24px;
  }
  .current-photo {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
    padding-bottom: 22px;
    border-bottom: 1px solid #e2e5e9;
  }
  .current-photo img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 6px;
  }
  .current-photo p {
    font-size: .78rem;
    color: #66717D;
  }

  label {
    display: block;
    font-size: .78rem;
    font-weight: 700;
    margin-bottom: 6px;
    margin-top: 16px;
  }
  label:first-of-type { margin-top: 0; }
  input[type="text"], select, textarea, input[type="file"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #D7DDE3;
    border-radius: 5px;
    font-size: .85rem;
  }
  textarea { min-height: 70px; resize: vertical; }
  input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #C62828;
  }
  p.hint {
    font-size: .75rem;
    color: #66717D;
    margin-top: 4px;
  }

  .actions {
    display: flex;
    gap: 10px;
    margin-top: 24px;
  }
  button.submit {
    background: #C62828;
    color: #fff;
    border: none;
    padding: 12px 22px;
    border-radius: 6px;
    font-weight: 800;
    font-size: .82rem;
    letter-spacing: .02em;
    cursor: pointer;
    transition: .2s;
  }
  button.submit:hover { background: #9F1F1F; }
  a.cancel {
    display: inline-flex;
    align-items: center;
    padding: 12px 20px;
    border: 1px solid #D7DDE3;
    border-radius: 6px;
    color: #1a1f27;
    font-size: .82rem;
    font-weight: 700;
    text-decoration: none;
  }
</style>
</head>
<body>
  <header>
    <h1>Modifier une photo — EGI-CI</h1>
    <a href="dashboard.php">← Retour</a>
  </header>

  <main>
    <?php if ($errorMsg): ?>
      <div class="msg error"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <div class="edit-card">
      <div class="current-photo">
        <img src="<?= GALLERY_URL . rawurlencode($current['filename']) ?>" alt="<?= htmlspecialchars($current['title']) ?>">
        <p>Photo actuelle. Laisse le champ fichier vide ci-dessous pour la conserver, ou choisis-en une nouvelle pour la remplacer.</p>
      </div>

      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($current['id']) ?>">

        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($current['title']) ?>" required>

        <label for="category">Catégorie</label>
        <select id="category" name="category" required>
          <?php foreach (CATEGORIES as $value => $label): ?>
            <option value="<?= htmlspecialchars($value) ?>" <?= $value === $current['category'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($label) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label for="description">Description</label>
        <textarea id="description" name="description"><?= htmlspecialchars($current['description'] ?? '') ?></textarea>

        <label for="photo">Remplacer la photo (optionnel)</label>
        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp">
        <p class="hint">Laisse vide pour garder la photo actuelle. Formats acceptés : JPG, PNG, WEBP — 5 Mo maximum.</p>

        <div class="actions">
          <button type="submit" class="submit">ENREGISTRER LES MODIFICATIONS</button>
          <a href="dashboard.php" class="cancel">Annuler</a>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
