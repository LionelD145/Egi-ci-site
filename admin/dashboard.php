<?php
require 'config.php';
requireLogin();

$successMsg = '';
$errorMsg = '';

if (isset($_GET['uploaded'])) $successMsg = 'Photo ajoutée avec succès. Elle apparaît déjà sur le site public.';
if (isset($_GET['updated'])) $successMsg = 'Photo modifiée avec succès.';
if (isset($_GET['deleted'])) $successMsg = 'Photo supprimée.';
if (isset($_GET['error'])) $errorMsg = htmlspecialchars($_GET['error']);

// Les plus récentes en premier
$photos = array_reverse(loadPhotos());
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gestion des photos — Administration EGI-CI</title>
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
    max-width: 1000px;
    margin: 0 auto;
    padding: 32px 20px 60px;
  }

  .msg {
    padding: 12px 16px;
    border-radius: 6px;
    font-size: .85rem;
    margin-bottom: 24px;
  }
  .msg.success { background: #e8f5e9; color: #2e7d32; }
  .msg.error { background: #fdecea; color: #c0392b; }

  .upload-card {
    background: #fff;
    border: 1px solid #e2e5e9;
    border-radius: 10px;
    padding: 24px;
    margin-bottom: 32px;
  }
  .upload-card h2 {
    font-size: .95rem;
    margin-bottom: 18px;
  }
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
  }
  .form-row.full { grid-template-columns: 1fr; }
  label {
    display: block;
    font-size: .78rem;
    font-weight: 700;
    margin-bottom: 6px;
    color: #1a1f27;
  }
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
  p.hint {
    font-size: .75rem;
    color: #66717D;
    margin-top: 4px;
  }
  p.required {
    font-size: .7rem;
    color: #C62828;
    margin-top: -10px;
    margin-bottom: 14px;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
  }
  .photo-card {
    background: #fff;
    border: 1px solid #e2e5e9;
    border-radius: 8px;
    overflow: hidden;
  }
  .photo-card .thumb {
    position: relative;
    height: 150px;
  }
  .photo-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
  }
  .photo-card .cat-tag {
    position: absolute;
    top: 8px;
    left: 8px;
    background: #C62828;
    color: #fff;
    font-size: .62rem;
    font-weight: 800;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: 4px 8px;
  }
  .photo-card .info {
    padding: 12px;
  }
  .photo-card h3 {
    font-size: .88rem;
    margin-bottom: 3px;
  }
  .photo-card p {
    font-size: .75rem;
    color: #66717D;
    margin-bottom: 10px;
    line-height: 1.4;
  }
  .card-actions {
    display: flex;
    gap: 8px;
  }
  .edit-btn {
    background: none;
    border: 1px solid #D7DDE3;
    color: #14275F;
    font-size: .72rem;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 700;
    text-decoration: none;
  }
  .edit-btn:hover { background: #eef1f6; }
  .delete-btn {
    background: none;
    border: 1px solid #f1c4c0;
    color: #c0392b;
    font-size: .72rem;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 700;
  }
  .delete-btn:hover { background: #fdecea; }
  .empty-state {
    text-align: center;
    color: #66717D;
    font-size: .85rem;
    padding: 40px 0;
  }
  h2.section-title {
    font-size: .95rem;
    margin-bottom: 16px;
  }
</style>
</head>
<body>
  <header>
    <h1>Gestion des photos — EGI-CI</h1>
    <a href="logout.php">Se déconnecter</a>
  </header>

  <main>
    <?php if ($successMsg): ?>
      <div class="msg success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
      <div class="msg error"><?= $errorMsg ?></div>
    <?php endif; ?>

    <div class="upload-card">
      <h2>Ajouter une photo</h2>
      <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="form-row">
          <div>
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" placeholder="Ex : Installation électrique" required>
          </div>
          <div>
            <label for="category">Catégorie</label>
            <select id="category" name="category" required>
              <option value="">— Choisir —</option>
              <?php foreach (CATEGORIES as $value => $label): ?>
                <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-row full">
          <div>
            <label for="description">Description (optionnelle)</label>
            <textarea id="description" name="description" placeholder="Une phrase courte décrivant la photo"></textarea>
          </div>
        </div>

        <div class="form-row full">
          <div>
            <label for="photo">Fichier photo</label>
            <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp" required>
            <p class="hint">Formats acceptés : JPG, PNG, WEBP — 5 Mo maximum.</p>
          </div>
        </div>

        <button type="submit" class="submit">AJOUTER LA PHOTO</button>
      </form>
    </div>

    <h2 class="section-title">Photos actuelles (<?= count($photos) ?>)</h2>

    <?php if (empty($photos)): ?>
      <div class="empty-state">Aucune photo pour le moment. Ajoutez-en une ci-dessus.</div>
    <?php else: ?>
      <div class="gallery-grid">
        <?php foreach ($photos as $photo): ?>
          <div class="photo-card">
            <div class="thumb">
              <span class="cat-tag"><?= htmlspecialchars(CATEGORIES[$photo['category']] ?? $photo['category']) ?></span>
              <img src="<?= GALLERY_URL . rawurlencode($photo['filename']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>">
            </div>
            <div class="info">
              <h3><?= htmlspecialchars($photo['title']) ?></h3>
              <p><?= htmlspecialchars($photo['description'] ?: '—') ?></p>
              <div class="card-actions">
                <a href="edit.php?id=<?= urlencode($photo['id']) ?>" class="edit-btn">Modifier</a>
                <form action="delete.php" method="POST" onsubmit="return confirm('Supprimer cette photo ?');">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($photo['id']) ?>">
                  <button type="submit" class="delete-btn">Supprimer</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
